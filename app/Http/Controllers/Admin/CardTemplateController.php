<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CardTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardTemplateController extends Controller
{
    public function index()
    {
        $templates = CardTemplate::latest()->paginate(10);
        return view('admin.card-templates.index', compact('templates'));
    }

    public function show(CardTemplate $cardTemplate)
    {
        return view('admin.card-templates.show', compact('cardTemplate'));
    }

    public function create()
    {
        return view('admin.card-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'width' => 'required|numeric|min:50|max:200',
            'height' => 'required|numeric|min:30|max:150',
            'front_design' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'back_design' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('front_design')) {
            $validated['front_design'] = $request->file('front_design')->store('templates/fronts', 'public');
        }

        if ($request->hasFile('back_design')) {
            $validated['back_design'] = $request->file('back_design')->store('templates/backs', 'public');
        }

        // Campos padrão para posicionamento
        $validated['front_fields'] = [
            'photo' => ['x' => 10, 'y' => 10, 'width' => 25, 'height' => 32],
            'name' => ['x' => 40, 'y' => 15, 'size' => 14],
            'position' => ['x' => 40, 'y' => 25, 'size' => 10],
            'department' => ['x' => 40, 'y' => 32, 'size' => 10],
            'serial' => ['x' => 10, 'y' => 45, 'size' => 8],
        ];

        $validated['back_fields'] = [
            'qr_code' => ['x' => 55, 'y' => 10, 'size' => 25],
            'expiry' => ['x' => 10, 'y' => 40, 'size' => 10],
            'verification_url' => ['x' => 10, 'y' => 45, 'size' => 8],
        ];

        CardTemplate::create($validated);

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template criado com sucesso!');
    }

    public function edit(CardTemplate $cardTemplate)
    {
        return view('admin.card-templates.edit', compact('cardTemplate'));
    }

    public function update(Request $request, CardTemplate $cardTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'width' => 'required|numeric|min:50|max:200',
            'height' => 'required|numeric|min:30|max:150',
            'front_design' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'back_design' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('front_design')) {
            if ($cardTemplate->front_design) {
                Storage::disk('public')->delete($cardTemplate->front_design);
            }
            $validated['front_design'] = $request->file('front_design')->store('templates/fronts', 'public');
        }

        if ($request->hasFile('back_design')) {
            if ($cardTemplate->back_design) {
                Storage::disk('public')->delete($cardTemplate->back_design);
            }
            $validated['back_design'] = $request->file('back_design')->store('templates/backs', 'public');
        }

        $cardTemplate->update($validated);

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template atualizado com sucesso!');
    }

    public function destroy(CardTemplate $cardTemplate)
    {
        if ($cardTemplate->cards()->count() > 0) {
            return redirect()->back()->with('error', 'Não é possível excluir um template que possui cartões emitidos.');
        }

        if ($cardTemplate->front_design) {
            Storage::disk('public')->delete($cardTemplate->front_design);
        }

        if ($cardTemplate->back_design) {
            Storage::disk('public')->delete($cardTemplate->back_design);
        }

        $cardTemplate->delete();

        return redirect()->route('admin.card-templates.index')
            ->with('success', 'Template excluído com sucesso!');
    }
}
