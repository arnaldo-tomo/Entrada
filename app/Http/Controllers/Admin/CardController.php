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
            return $this->exportImage($card, $format);
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

    // private function exportPdf(Card $card)
    // {
    //     $pdf = Pdf::loadView('admin.cards.pdf', compact('card'))
    //         ->setPaper([0, 0, $card->cardTemplate->width * 2.83, $card->cardTemplate->height * 2.83]);

    //     return $pdf->download('cartao-' . $card->serial_number . '.pdf');
    // }

    private function exportImage(Card $card, $format)
    {
        // Para implementação completa, seria necessário usar uma biblioteca como Intervention Image
        // Por agora, retornamos um redirect para o preview
        return redirect()->route('admin.cards.preview', $card);
    }

    private function exportPdf(Card $card)
{
    // Carregar as informações necessárias
    $card->load(['employee', 'cardTemplate', 'verificationLogs']);

    // Configurar o PDF com orientação e tamanho adequados
    $pdf = Pdf::loadView('admin.cards.pdf', compact('card'))
        ->setPaper('A4', 'portrait')
        ->setOptions([
            'defaultFont' => 'Arial',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'dpi' => 300,
            'defaultPaperSize' => 'A4',
            'fontHeightRatio' => 1.1,
            'chroot' => public_path(),
        ]);

    return $pdf->download('cartao-' . $card->serial_number . '.pdf');
}
}
