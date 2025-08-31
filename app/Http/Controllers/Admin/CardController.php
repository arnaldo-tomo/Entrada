<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Employee;
use App\Models\CardTemplate;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // ou Imagick\Driver
// No controller, use assim:


$manager = new ImageManager(new Driver());

use Carbon\Carbon;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::with(['employee', 'cardTemplate']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('identification_number', 'like', "%{$search}%");
            })->orWhere('serial_number', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cards = $query->latest()->paginate(15);

        return view('admin.cards.index', compact('cards'));
    }

    public function show(Card $card)
    {
        $card->load(['employee', 'cardTemplate', 'verificationLogs']);
        return view('admin.cards.show', compact('card'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        $templates = CardTemplate::where('is_active', true)->orderBy('name')->get();

        return view('admin.cards.create', compact('employees', 'templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'card_template_id' => 'required|exists:card_templates,id',
            'expiry_date' => 'required|date|after:today',
        ]);

        // Revogar cartão ativo anterior se existir
        $employee = Employee::find($validated['employee_id']);
        $activeCard = $employee->activeCard();
        if ($activeCard) {
            $activeCard->update([
                'status' => 'revoked',
                'revoked_at' => now(),
                'revoked_reason' => 'Substituído por novo cartão'
            ]);
        }

        $validated['issued_date'] = now();
        $card = Card::create($validated);

        // Gerar QR Code
        $this->generateQrCode($card);

        return redirect()->route('admin.cards.show', $card)
            ->with('success', 'Cartão emitido com sucesso!');
    }

    public function revoke(Request $request, Card $card)
    {
        $validated = $request->validate([
            'revoked_reason' => 'required|string|max:255'
        ]);

        $card->update([
            'status' => 'revoked',
            'revoked_at' => now(),
            'revoked_reason' => $validated['revoked_reason']
        ]);

        return redirect()->back()->with('success', 'Cartão revogado com sucesso!');
    }

    public function preview(Card $card)
    {
        return view('admin.cards.preview', compact('card'));
    }

    public function export(Card $card, $format)
    {
        if (!in_array($format, ['pdf', 'png', 'jpg'])) {
            abort(404);
        }

      if ($format === 'pdf') {
        return $this->exportPdf($card);
    } else {
        return $this->exportImageGD($card, $format);
    }
    }

    private function generateQrCode(Card $card)
    {
        $qrPath = 'qr-codes/' . $card->verification_token . '.png';

        $qrCode = QrCode::format('png')
            ->size(200)
            ->margin(1)
            ->generate($card->verification_url);

        Storage::disk('public')->put($qrPath, $qrCode);

        $card->update(['qr_code_path' => $qrPath]);
    }

 private function exportPdf(Card $card)
{
    // Garantir que o cartão tem todas as relações carregadas
    $card->load(['employee', 'cardTemplate']);

    // Verificar se o template existe e tem dimensões válidas
    if (!$card->cardTemplate) {
        throw new \Exception('Template do cartão não encontrado');
    }

    $width = $card->cardTemplate->width ?? 85.6; // Dimensão padrão de cartão em mm
    $height = $card->cardTemplate->height ?? 53.98;

    try {
        $pdf = Pdf::loadView('admin.cards.pdf', compact('card'))
            ->setPaper([0, 0, $width * 2.83, $height * 2.83]); // Conversão mm para pontos

        return $pdf->download('cartao-' . ($card->serial_number ?? 'sem-numero') . '.pdf');
    } catch (\Exception $e) {
        // Log do erro para debugging
        \Log::error('Erro ao gerar PDF do cartão: ' . $e->getMessage(), [
            'card_id' => $card->id,
            'employee_id' => $card->employee_id ?? null,
            'template_id' => $card->card_template_id ?? null
        ]);

        return redirect()->back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
    }
}


private function exportImage(Card $card, $format = 'png')
{
    $card->load(['employee', 'cardTemplate']);

    // Criar manager de imagem
    $manager = new ImageManager(new Driver());

    // Dimensões do cartão (em pixels, alta resolução)
    $width = (int)($card->cardTemplate->width * 12); // Aproximadamente 300 DPI
    $height = (int)($card->cardTemplate->height * 12);

    try {
        // Criar as duas faces do cartão
        $frontCard = $this->createCardFrontV3($manager, $card, $width, $height);
        $backCard = $this->createCardBackV3($manager, $card, $width, $height);

        // Criar uma imagem combinada (lado a lado)
        $combinedWidth = $width * 2 + 60; // espaço entre cartões
        $combinedHeight = $height + 80; // margem superior e inferior

        $combined = $manager->create($combinedWidth, $combinedHeight)->fill('#f8f9fa');

        // Posicionar os cartões
        $combined->place($frontCard, 'top-left', 30, 40);
        $combined->place($backCard, 'top-left', $width + 60, 40);

        // Adicionar títulos
        $combined->text('FRENTE', $width/2 + 30, 25, function($font) {
            $font->size(20);
            $font->color('#666');
        });

        $combined->text('VERSO', $width + $width/2 + 60, 25, function($font) {
            $font->size(20);
            $font->color('#666');
        });

        // Salvar e retornar
        $filename = 'cartao-' . $card->serial_number . '.' . $format;

        if ($format === 'jpg') {
            $encoded = $combined->toJpeg(90);
        } else {
            $encoded = $combined->toPng();
        }

        return response($encoded)
            ->header('Content-Type', 'image/' . $format)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

    } catch (\Exception $e) {
        \Log::error('Erro na geração da imagem: ' . $e->getMessage());
        return back()->with('error', 'Erro ao gerar imagem: ' . $e->getMessage());
    }
}

private function createCardFrontV3($manager, Card $card, int $width, int $height)
{
    // Criar canvas para a frente com gradiente
    $img = $manager->create($width, $height);

    // Criar gradiente manual (de azul para azul mais claro)
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)(41 + (52 - 41) * $ratio);
        $g = (int)(128 + (152 - 128) * $ratio);
        $b = (int)(185 + (219 - 185) * $ratio);

        $img->drawRectangle(0, $y, $width, $y + 1, function($drawable) use ($r, $g, $b) {
            $drawable->background("rgb($r, $g, $b)");
        });
    }

    // Foto do colaborador
    $photoX = 30;
    $photoY = 40;
    $photoWidth = 96;
    $photoHeight = 120;

    if ($card->employee->photo && file_exists(public_path('storage/' . $card->employee->photo))) {
        try {
            $photo = $manager->read(public_path('storage/' . $card->employee->photo))
                ->cover($photoWidth, $photoHeight);

            // Fundo branco para a foto
            $img->drawRectangle($photoX - 4, $photoY - 4, $photoX + $photoWidth + 4, $photoY + $photoHeight + 4, function($drawable) {
                $drawable->background('white');
            });

            $img->place($photo, 'top-left', $photoX, $photoY);
        } catch (\Exception $e) {
            // Fallback se erro na foto
            $img->drawRectangle($photoX, $photoY, $photoX + $photoWidth, $photoY + $photoHeight, function($drawable) {
                $drawable->background('rgba(255,255,255,0.3)');
                $drawable->border('white', 2);
            });
        }
    } else {
        // Placeholder para foto
        $img->drawRectangle($photoX, $photoY, $photoX + $photoWidth, $photoY + $photoHeight, function($drawable) {
            $drawable->background('rgba(255,255,255,0.3)');
            $drawable->border('white', 2);
        });

        $img->text('SEM FOTO', $photoX + $photoWidth/2, $photoY + $photoHeight/2, function($font) {
            $font->size(16);
            $font->color('white');
        });
    }

    // Informações do colaborador
    $infoX = $photoX + $photoWidth + 30;
    $infoY = 60;

    // Nome (quebrar linha se muito longo)
    $name = $card->employee->name;
    if (strlen($name) > 20) {
        $words = explode(' ', $name);
        $line1 = '';
        $line2 = '';
        $currentLine = 1;

        foreach ($words as $word) {
            if ($currentLine === 1 && strlen($line1 . ' ' . $word) <= 20) {
                $line1 .= ($line1 ? ' ' : '') . $word;
            } else {
                $currentLine = 2;
                $line2 .= ($line2 ? ' ' : '') . $word;
            }
        }

        $img->text($line1, $infoX, $infoY, function($font) {
            $font->size(22);
            $font->color('white');
        });

        if ($line2) {
            $img->text($line2, $infoX, $infoY + 30, function($font) {
                $font->size(22);
                $font->color('white');
            });
            $infoY += 30; // Ajustar posição dos próximos elementos
        }
    } else {
        $img->text($name, $infoX, $infoY, function($font) {
            $font->size(22);
            $font->color('white');
        });
    }

    // Cargo
    $img->text($card->employee->position, $infoX, $infoY + 40, function($font) {
        $font->size(18);
        $font->color('white');
    });

    // Departamento
    $img->text($card->employee->department, $infoX, $infoY + 65, function($font) {
        $font->size(16);
        $font->color('rgba(255,255,255,0.9)');
    });

    // ID
    $img->text('ID: ' . $card->employee->identification_number, $infoX, $infoY + 90, function($font) {
        $font->size(14);
        $font->color('rgba(255,255,255,0.8)');
    });

    // Header
    $img->text(config('app.name', 'SISTEMA'), 30, 25, function($font) {
        $font->size(16);
        $font->color('white');
    });

    $img->text('ID CARD', $width - 30, 25, function($font) {
        $font->size(14);
        $font->color('white');
    });

    // Footer
    $img->text($card->serial_number, 30, $height - 20, function($font) {
        $font->size(12);
        $font->color('rgba(255,255,255,0.8)');
    });

    $img->text($card->issued_date->format('m/Y'), $width - 30, $height - 20, function($font) {
        $font->size(12);
        $font->color('rgba(255,255,255,0.8)');
    });

    return $img;
}

private function createCardBackV3($manager, Card $card, int $width, int $height)
{
    // Criar canvas para o verso com gradiente escuro
    $img = $manager->create($width, $height);

    // Gradiente escuro
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)(52 + (44 - 52) * $ratio);
        $g = (int)(73 + (62 - 73) * $ratio);
        $b = (int)(94 + (80 - 94) * $ratio);

        $img->drawRectangle(0, $y, $width, $y + 1, function($drawable) use ($r, $g, $b) {
            $drawable->background("rgb($r, $g, $b)");
        });
    }

    // Título
    $img->text('CARTÃO DE IDENTIFICAÇÃO', $width/2, 40, function($font) {
        $font->size(20);
        $font->color('white');
    });

    $img->text('Este cartão é propriedade da empresa', $width/2, 70, function($font) {
        $font->size(14);
        $font->color('rgba(255,255,255,0.8)');
    });

    // QR Code
    $qrSize = 100;
    $qrX = 50;
    $qrY = 110;

    if ($card->qr_code_path && file_exists(public_path('storage/' . $card->qr_code_path))) {
        try {
            // Fundo branco para o QR
            $img->drawRectangle($qrX - 6, $qrY - 6, $qrX + $qrSize + 6, $qrY + $qrSize + 6, function($drawable) {
                $drawable->background('white');
            });

            $qr = $manager->read(public_path('storage/' . $card->qr_code_path))
                ->resize($qrSize, $qrSize);

            $img->place($qr, 'top-left', $qrX, $qrY);
        } catch (\Exception $e) {
            // Fallback QR
            $img->drawRectangle($qrX, $qrY, $qrX + $qrSize, $qrY + $qrSize, function($drawable) {
                $drawable->background('#f8f9fa');
                $drawable->border('#ddd', 2);
            });

            $img->text('QR CODE', $qrX + $qrSize/2, $qrY + $qrSize/2, function($font) {
                $font->size(14);
                $font->color('#666');
            });
        }
    } else {
        // Placeholder QR
        $img->drawRectangle($qrX, $qrY, $qrX + $qrSize, $qrY + $qrSize, function($drawable) {
            $drawable->background('#f8f9fa');
            $drawable->border('#ddd', 2);
        });

        $img->text('QR CODE', $qrX + $qrSize/2, $qrY + $qrSize/2, function($font) {
            $font->size(14);
            $font->color('#666');
        });
    }

    $img->text('Escaneie para verificar', $qrX + $qrSize/2, $qrY + $qrSize + 20, function($font) {
        $font->size(12);
        $font->color('rgba(255,255,255,0.8)');
    });

    // Informações de validade
    $validityX = $width - 50;
    $validityY = 130;

    $img->text('Válido até:', $validityX, $validityY, function($font) {
        $font->size(14);
        $font->color('rgba(255,255,255,0.8)');
    });

    $img->text($card->expiry_date->format('d/m/Y'), $validityX, $validityY + 30, function($font) {
        $font->size(24);
        $font->color('white');
    });

    // Footer de aviso
    $img->text('Em caso de perda, comunique imediatamente', $width/2, $height - 40, function($font) {
        $font->size(12);
        $font->color('rgba(255,255,255,0.7)');
    });

    $img->text('Este documento é intransferível', $width/2, $height - 20, function($font) {
        $font->size(12);
        $font->color('rgba(255,255,255,0.7)');
    });

    return $img;
}

// OPÇÃO 2: Alternativa usando GD nativo do PHP (se Intervention não funcionar)

private function exportImageGD(Card $card, $format = 'png')
{
    $card->load(['employee', 'cardTemplate']);

    // Dimensões do cartão (alta resolução para impressão)
    $cardWidth = (int)($card->cardTemplate->width * 12);  // ~300 DPI
    $cardHeight = (int)($card->cardTemplate->height * 12);

    try {
        // Criar as duas faces do cartão
        $frontCard = $this->createCardFrontGD($card, $cardWidth, $cardHeight);
        $backCard = $this->createCardBackGD($card, $cardWidth, $cardHeight);

        // Criar imagem combinada (frente e verso lado a lado)
        $spacing = 60;
        $margin = 40;
        $combinedWidth = ($cardWidth * 2) + $spacing + ($margin * 2);
        $combinedHeight = $cardHeight + ($margin * 2) + 60; // espaço para títulos

        $combined = imagecreatetruecolor($combinedWidth, $combinedHeight);

        // Fundo cinza claro
        $bgColor = imagecolorallocate($combined, 248, 249, 250);
        imagefill($combined, 0, 0, $bgColor);

        // Posicionar os cartões
        imagecopy($combined, $frontCard, $margin, $margin + 30, 0, 0, $cardWidth, $cardHeight);
        imagecopy($combined, $backCard, $margin + $cardWidth + $spacing, $margin + 30, 0, 0, $cardWidth, $cardHeight);

        // Adicionar títulos
        $titleColor = imagecolorallocate($combined, 102, 102, 102);
        $titleFont = 5; // Tamanho da fonte built-in

        // Centralizar títulos
        $frontTitleX = $margin + ($cardWidth / 2) - 30;
        $backTitleX = $margin + $cardWidth + $spacing + ($cardWidth / 2) - 25;

        imagestring($combined, $titleFont, $frontTitleX, 10, 'FRENTE', $titleColor);
        imagestring($combined, $titleFont, $backTitleX, 10, 'VERSO', $titleColor);

        // Adicionar informações no rodapé
        $infoY = $combinedHeight - 25;
        imagestring($combined, 2, $margin, $infoY, 'Cartao: ' . $card->serial_number, $titleColor);
        imagestring($combined, 2, $combinedWidth - 200, $infoY, 'Gerado em: ' . now()->format('d/m/Y H:i'), $titleColor);

        // Output da imagem
        ob_start();
        if ($format === 'jpg' || $format === 'jpeg') {
            imagejpeg($combined, null, 95);
            $contentType = 'image/jpeg';
        } else {
            imagepng($combined);
            $contentType = 'image/png';
        }
        $imageData = ob_get_contents();
        ob_end_clean();

        // Limpar memória
        imagedestroy($combined);
        imagedestroy($frontCard);
        imagedestroy($backCard);

        $filename = 'cartao-' . $card->serial_number . '.' . $format;

        return response($imageData)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

    } catch (\Exception $e) {
        \Log::error('Erro na geração da imagem: ' . $e->getMessage(), [
            'card_id' => $card->id,
            'trace' => $e->getTraceAsString()
        ]);

        return back()->with('error', 'Erro ao gerar imagem: ' . $e->getMessage());
    }
}

private function createCardFrontGD(Card $card, int $width, int $height)
{
    $img = imagecreatetruecolor($width, $height);

    // Criar gradiente azul (de azul escuro para azul claro)
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)(41 + (52 - 41) * $ratio);   // 2980b9 -> 3498db
        $g = (int)(128 + (152 - 128) * $ratio);
        $b = (int)(185 + (219 - 185) * $ratio);
        $color = imagecolorallocate($img, $r, $g, $b);
        imageline($img, 0, $y, $width, $y, $color);
    }

    // Cores
    $white = imagecolorallocate($img, 255, 255, 255);
    $lightWhite = imagecolorallocate($img, 255, 255, 255);
    $transparentWhite = imagecolorallocate($img, 200, 200, 255);

    // Configurações de posição
    $padding = (int)($width * 0.06); // 6% da largura como padding
    $photoSize = (int)($width * 0.25); // 25% da largura
    $photoHeight = (int)($height * 0.6); // 60% da altura

    // Header - Nome da empresa e tipo do cartão
    $headerY = (int)($height * 0.08);
    imagestring($img, 4, $padding, $headerY, strtoupper(config('app.name', 'SISTEMA')), $white);

    $idCardText = 'ID CARD';
    $idCardX = $width - $padding - (strlen($idCardText) * 10);
    imagestring($img, 3, $idCardX, $headerY, $idCardText, $lightWhite);

    // Área da foto
    $photoX = $padding;
    $photoY = (int)($height * 0.25);

    // Carregar e redimensionar foto se existir
    if ($card->employee->photo && file_exists(public_path('storage/' . $card->employee->photo))) {
        $photoPath = public_path('storage/' . $card->employee->photo);
        $photo = null;

        $extension = strtolower(pathinfo($photoPath, PATHINFO_EXTENSION));
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $photo = imagecreatefromjpeg($photoPath);
                break;
            case 'png':
                $photo = imagecreatefrompng($photoPath);
                break;
            case 'gif':
                $photo = imagecreatefromgif($photoPath);
                break;
        }

        if ($photo) {
            // Criar fundo branco para a foto
            $photoFrame = imagecolorallocate($img, 255, 255, 255);
            imagefilledrectangle($img, $photoX - 4, $photoY - 4, $photoX + $photoSize + 4, $photoY + $photoHeight + 4, $photoFrame);

            // Redimensionar e inserir foto
            $photoResized = imagescale($photo, $photoSize, $photoHeight);
            imagecopy($img, $photoResized, $photoX, $photoY, 0, 0, $photoSize, $photoHeight);

            imagedestroy($photo);
            imagedestroy($photoResized);
        } else {
            // Placeholder se não conseguir carregar a foto
            $placeholderBg = imagecolorallocate($img, 200, 200, 255);
            imagefilledrectangle($img, $photoX, $photoY, $photoX + $photoSize, $photoY + $photoHeight, $placeholderBg);

            $placeholderText = 'FOTO';
            $textX = $photoX + ($photoSize / 2) - 20;
            $textY = $photoY + ($photoHeight / 2);
            imagestring($img, 3, $textX, $textY, $placeholderText, imagecolorallocate($img, 100, 100, 100));
        }
    } else {
        // Placeholder quando não há foto
        $placeholderBg = imagecolorallocate($img, 200, 200, 255);
        imagefilledrectangle($img, $photoX, $photoY, $photoX + $photoSize, $photoY + $photoHeight, $placeholderBg);

        $placeholderText = 'SEM FOTO';
        $textX = $photoX + ($photoSize / 2) - 35;
        $textY = $photoY + ($photoHeight / 2);
        imagestring($img, 3, $textX, $textY, $placeholderText, imagecolorallocate($img, 100, 100, 100));
    }

    // Informações do colaborador
    $infoX = $photoX + $photoSize + (int)($width * 0.08);
    $infoY = $photoY;
    $lineHeight = (int)($height * 0.08);

    // Nome (quebrar em duas linhas se muito longo)
    $name = $card->employee->name;
    if (strlen($name) > 18) {
        $words = explode(' ', $name);
        $line1 = '';
        $line2 = '';

        foreach ($words as $word) {
            if (strlen($line1 . ' ' . $word) <= 18) {
                $line1 .= ($line1 ? ' ' : '') . $word;
            } else {
                $line2 .= ($line2 ? ' ' : '') . $word;
            }
        }

        imagestring($img, 5, $infoX, $infoY, $line1, $white);
        if ($line2) {
            imagestring($img, 5, $infoX, $infoY + $lineHeight, $line2, $white);
            $infoY += $lineHeight;
        }
    } else {
        imagestring($img, 5, $infoX, $infoY, $name, $white);
    }

    // Cargo
    imagestring($img, 4, $infoX, $infoY + $lineHeight, $card->employee->position, $lightWhite);

    // Departamento
    imagestring($img, 3, $infoX, $infoY + ($lineHeight * 2), $card->employee->department, $transparentWhite);

    // ID do colaborador
    $idText = 'ID: ' . $card->employee->identification_number;
    imagestring($img, 2, $infoX, $infoY + ($lineHeight * 2.8), $idText, $transparentWhite);

    // Footer
    $footerY = $height - (int)($height * 0.08);
    imagestring($img, 2, $padding, $footerY, $card->serial_number, $transparentWhite);

    $dateText = $card->issued_date->format('m/Y');
    $dateX = $width - $padding - (strlen($dateText) * 7);
    imagestring($img, 2, $dateX, $footerY, $dateText, $transparentWhite);

    return $img;
}

private function createCardBackGD(Card $card, int $width, int $height)
{
    $img = imagecreatetruecolor($width, $height);

    // Criar gradiente cinza escuro
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)(52 + (44 - 52) * $ratio);   // 34495e -> 2c3e50
        $g = (int)(73 + (62 - 73) * $ratio);
        $b = (int)(94 + (80 - 94) * $ratio);
        $color = imagecolorallocate($img, $r, $g, $b);
        imageline($img, 0, $y, $width, $y, $color);
    }

    // Cores
    $white = imagecolorallocate($img, 255, 255, 255);
    $lightGray = imagecolorallocate($img, 200, 200, 200);
    $mediumGray = imagecolorallocate($img, 180, 180, 180);

    $padding = (int)($width * 0.06);

    // Título principal
    $titleY = (int)($height * 0.15);
    $titleText = 'CARTAO DE IDENTIFICACAO';
    $titleX = ($width / 2) - ((strlen($titleText) * 8) / 2);
    imagestring($img, 4, $titleX, $titleY, $titleText, $white);

    // Subtítulo
    $subtitleY = $titleY + 25;
    $subtitleText = 'Este cartao e propriedade da empresa';
    $subtitleX = ($width / 2) - ((strlen($subtitleText) * 6) / 2);
    imagestring($img, 2, $subtitleX, $subtitleY, $subtitleText, $lightGray);

    // QR Code area
    $qrSize = (int)($width * 0.3);
    $qrX = $padding;
    $qrY = (int)($height * 0.4);

    if ($card->qr_code_path && file_exists(public_path('storage/' . $card->qr_code_path))) {
        // Carregar QR Code
        $qrPath = public_path('storage/' . $card->qr_code_path);
        $qr = imagecreatefrompng($qrPath);

        if ($qr) {
            // Fundo branco para o QR
            $qrBg = imagecolorallocate($img, 255, 255, 255);
            imagefilledrectangle($img, $qrX - 8, $qrY - 8, $qrX + $qrSize + 8, $qrY + $qrSize + 8, $qrBg);

            // Redimensionar e inserir QR
            $qrResized = imagescale($qr, $qrSize, $qrSize);
            imagecopy($img, $qrResized, $qrX, $qrY, 0, 0, $qrSize, $qrSize);

            imagedestroy($qr);
            imagedestroy($qrResized);
        }
    } else {
        // Placeholder QR
        $qrBg = imagecolorallocate($img, 248, 249, 250);
        $qrBorder = imagecolorallocate($img, 200, 200, 200);
        imagefilledrectangle($img, $qrX, $qrY, $qrX + $qrSize, $qrY + $qrSize, $qrBg);
        imagerectangle($img, $qrX, $qrY, $qrX + $qrSize, $qrY + $qrSize, $qrBorder);

        $qrText = 'QR CODE';
        $qrTextX = $qrX + ($qrSize / 2) - 35;
        $qrTextY = $qrY + ($qrSize / 2);
        imagestring($img, 4, $qrTextX, $qrTextY, $qrText, imagecolorallocate($img, 102, 102, 102));
    }

    // Label do QR
    $qrLabelY = $qrY + $qrSize + 15;
    $qrLabel = 'Escaneie para verificar';
    $qrLabelX = $qrX + ($qrSize / 2) - ((strlen($qrLabel) * 6) / 2);
    imagestring($img, 2, $qrLabelX, $qrLabelY, $qrLabel, $lightGray);

    // Informações de validade (lado direito)
    $validityX = $width - $padding - 150;
    $validityY = (int)($height * 0.45);

    imagestring($img, 3, $validityX, $validityY, 'Valido ate:', $mediumGray);
    imagestring($img, 5, $validityX, $validityY + 30, $card->expiry_date->format('d/m/Y'), $white);

    // URL de verificação (pequena)
    $urlY = $validityY + 70;
    imagestring($img, 1, $validityX, $urlY, 'Para verificar:', $mediumGray);

    $shortUrl = str_replace(['http://', 'https://'], '', config('app.url'));
    imagestring($img, 1, $validityX, $urlY + 12, $shortUrl . '/v/', $mediumGray);
    imagestring($img, 1, $validityX, $urlY + 24, substr($card->verification_token, 0, 16) . '...', $mediumGray);

    // Footer de aviso
    $footerY = $height - 40;
    $warningText1 = 'Em caso de perda ou roubo, comunique imediatamente';
    $warningX1 = ($width / 2) - ((strlen($warningText1) * 5) / 2);
    imagestring($img, 1, $warningX1, $footerY, $warningText1, $mediumGray);

    $warningText2 = 'Este documento e intransferivel';
    $warningX2 = ($width / 2) - ((strlen($warningText2) * 5) / 2);
    imagestring($img, 1, $warningX2, $footerY + 15, $warningText2, $mediumGray);

    return $img;
}


private function createCardFront(Card $card, int $width, int $height)
{
    // Criar canvas para a frente
    $img = Image::canvas($width, $height);

    // Fundo gradiente (simulado com retângulos)
    for ($i = 0; $i < $height; $i++) {
        $ratio = $i / $height;
        $r = (int)(41 + (52 - 41) * $ratio);   // De #2980b9 para #3498db
        $g = (int)(128 + (152 - 128) * $ratio);
        $b = (int)(185 + (219 - 185) * $ratio);
        $color = sprintf('#%02x%02x%02x', $r, $g, $b);

        $img->line(0, $i, $width, $i, function($draw) use ($color) {
            $draw->color($color);
        });
    }

    // Adicionar bordas arredondadas (opcional, mais complexo)

    // Foto do colaborador
    $photoX = 20;
    $photoY = 30;
    $photoWidth = 80;
    $photoHeight = 100;

    if ($card->employee->photo && file_exists(public_path('storage/' . $card->employee->photo))) {
        $photo = Image::make(public_path('storage/' . $card->employee->photo))
            ->fit($photoWidth, $photoHeight)
            ->brightness(5);

        // Adicionar borda branca na foto
        $photoWithBorder = Image::canvas($photoWidth + 4, $photoHeight + 4, '#ffffff');
        $photoWithBorder->insert($photo, 'center');

        $img->insert($photoWithBorder, 'top-left', $photoX - 2, $photoY - 2);
    } else {
        // Placeholder para foto
        $img->rectangle($photoX, $photoY, $photoX + $photoWidth, $photoY + $photoHeight, function($draw) {
            $draw->background('rgba(255,255,255,0.3)');
            $draw->border(2, '#ffffff');
        });

        $img->text('SEM FOTO', $photoX + $photoWidth/2, $photoY + $photoHeight/2, function($font) {
            $font->size(10);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
    }

    // Informações do colaborador
    $infoX = $photoX + $photoWidth + 20;
    $infoY = 40;

    // Nome
    $img->text($card->employee->name, $infoX, $infoY, function($font) {
        $font->size(18);
        $font->color('#ffffff');
        $font->weight('bold');
    });

    // Cargo
    $img->text($card->employee->position, $infoX, $infoY + 25, function($font) {
        $font->size(14);
        $font->color('#ffffff');
    });

    // Departamento
    $img->text($card->employee->department, $infoX, $infoY + 45, function($font) {
        $font->size(12);
        $font->color('rgba(255,255,255,0.9)');
    });

    // ID
    $img->text('ID: ' . $card->employee->identification_number, $infoX, $infoY + 70, function($font) {
        $font->size(10);
        $font->color('rgba(255,255,255,0.8)');
        $font->family('monospace');
    });

    // Header
    $img->text(config('app.name', 'EMPRESA'), 20, 20, function($font) {
        $font->size(12);
        $font->color('#ffffff');
        $font->weight('bold');
    });

    $img->text('ID CARD', $width - 20, 20, function($font) {
        $font->size(10);
        $font->color('#ffffff');
        $font->align('right');
    });

    // Footer
    $img->text($card->serial_number, 20, $height - 15, function($font) {
        $font->size(9);
        $font->color('rgba(255,255,255,0.8)');
    });

    $img->text($card->issued_date->format('m/Y'), $width - 20, $height - 15, function($font) {
        $font->size(9);
        $font->color('rgba(255,255,255,0.8)');
        $font->align('right');
    });

    return $img;
}

private function createCardBack(Card $card, int $width, int $height)
{
    // Criar canvas para o verso
    $img = Image::canvas($width, $height);

    // Fundo gradiente escuro
    for ($i = 0; $i < $height; $i++) {
        $ratio = $i / $height;
        $r = (int)(52 + (44 - 52) * $ratio);   // De #34495e para #2c3e50
        $g = (int)(73 + (62 - 73) * $ratio);
        $b = (int)(94 + (80 - 94) * $ratio);
        $color = sprintf('#%02x%02x%02x', $r, $g, $b);

        $img->line(0, $i, $width, $i, function($draw) use ($color) {
            $draw->color($color);
        });
    }

    // Título
    $img->text('CARTÃO DE IDENTIFICAÇÃO', $width/2, 30, function($font) {
        $font->size(14);
        $font->color('#ffffff');
        $font->weight('bold');
        $font->align('center');
    });

    $img->text('Este cartão é propriedade da empresa', $width/2, 50, function($font) {
        $font->size(10);
        $font->color('rgba(255,255,255,0.8)');
        $font->align('center');
    });

    // QR Code
    $qrSize = 80;
    $qrX = 30;
    $qrY = 80;

    if ($card->qr_code_path && file_exists(public_path('storage/' . $card->qr_code_path))) {
        // Fundo branco para o QR
        $img->rectangle($qrX - 5, $qrY - 5, $qrX + $qrSize + 5, $qrY + $qrSize + 5, function($draw) {
            $draw->background('#ffffff');
        });

        $qr = Image::make(public_path('storage/' . $card->qr_code_path))
            ->resize($qrSize, $qrSize);

        $img->insert($qr, 'top-left', $qrX, $qrY);
    } else {
        // Placeholder QR
        $img->rectangle($qrX, $qrY, $qrX + $qrSize, $qrY + $qrSize, function($draw) {
            $draw->background('#f8f9fa');
            $draw->border(2, '#ddd');
        });

        $img->text('QR CODE', $qrX + $qrSize/2, $qrY + $qrSize/2, function($font) {
            $font->size(10);
            $font->color('#666');
            $font->align('center');
            $font->valign('center');
        });
    }

    $img->text('Escaneie para verificar', $qrX + $qrSize/2, $qrY + $qrSize + 15, function($font) {
        $font->size(8);
        $font->color('rgba(255,255,255,0.8)');
        $font->align('center');
    });

    // Informações de validade
    $validityX = $width - 30;
    $validityY = 90;

    $img->text('Válido até:', $validityX, $validityY, function($font) {
        $font->size(10);
        $font->color('rgba(255,255,255,0.8)');
        $font->align('right');
    });

    $img->text($card->expiry_date->format('d/m/Y'), $validityX, $validityY + 20, function($font) {
        $font->size(16);
        $font->color('#ffffff');
        $font->weight('bold');
        $font->align('right');
    });

    // URL de verificação
    $url = config('app.url') . '/v/' . $card->verification_token;
    $img->text('Verificar em:', $validityX, $validityY + 45, function($font) {
        $font->size(8);
        $font->color('rgba(255,255,255,0.7)');
        $font->align('right');
    });

    // Quebrar URL se muito longa
    $shortUrl = str_replace(['http://', 'https://'], '', $url);
    if (strlen($shortUrl) > 25) {
        $shortUrl = substr($shortUrl, 0, 25) . '...';
    }

    $img->text($shortUrl, $validityX, $validityY + 60, function($font) {
        $font->size(7);
        $font->color('rgba(255,255,255,0.7)');
        $font->align('right');
    });

    // Footer de aviso
    $img->text('Em caso de perda ou roubo, comunique imediatamente', $width/2, $height - 25, function($font) {
        $font->size(8);
        $font->color('rgba(255,255,255,0.7)');
        $font->align('center');
    });

    $img->text('Este documento é intransferível', $width/2, $height - 10, function($font) {
        $font->size(8);
        $font->color('rgba(255,255,255,0.7)');
        $font->align('center');
    });

    return $img;
}

}
