<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\VerificationLog;
use Illuminate\Http\Request;

class CardVerificationController extends Controller
{
    public function verify(Request $request, $token)
    {
        $card = Card::where('verification_token', $token)
            ->with(['employee', 'cardTemplate'])
            ->first();

        if (!$card) {
            return view('verification.not-found');
        }

        // Log da verificação
        VerificationLog::create([
            'card_id' => $card->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'verified_at' => now(),
        ]);

        // Atualizar status se expirado
        if ($card->isExpired() && $card->status !== 'expired') {
            $card->update(['status' => 'expired']);
        }

        return view('verification.show', compact('card'));
    }
}
