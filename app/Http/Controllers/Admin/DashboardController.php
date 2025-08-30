<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Card;
use App\Models\CardTemplate;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'total_cards' => Card::count(),
            'active_cards' => Card::where('status', 'active')->count(),
            'expired_cards' => Card::where('status', 'expired')->orWhere('expiry_date', '<', now())->count(),
            'revoked_cards' => Card::where('status', 'revoked')->count(),
            'total_templates' => CardTemplate::where('is_active', true)->count(),
        ];

        $recent_cards = Card::with(['employee', 'cardTemplate'])
            ->latest()
            ->limit(5)
            ->get();

        $monthly_cards = Card::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthly_cards[$i])) {
                $monthly_cards[$i] = 0;
            }
        }
        ksort($monthly_cards);

        return view('admin.dashboard', compact('stats', 'recent_cards', 'monthly_cards'));
    }
}
