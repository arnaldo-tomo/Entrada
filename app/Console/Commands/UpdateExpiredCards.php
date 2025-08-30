<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Card;
use Carbon\Carbon;

class UpdateExpiredCards extends Command
{
    protected $signature = 'cards:update-expired';
    protected $description = 'Atualiza o status dos cartões expirados';

    public function handle()
    {
        $expiredCards = Card::where('status', 'active')
            ->where('expiry_date', '<', now())
            ->get();

        $count = $expiredCards->count();

        foreach ($expiredCards as $card) {
            $card->update(['status' => 'expired']);
        }

        $this->info("✓ {$count} cartão(s) marcado(s) como expirado(s)");

        return Command::SUCCESS;
    }
}
