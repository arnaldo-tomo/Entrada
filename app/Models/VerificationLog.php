<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'ip_address',
        'user_agent',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime'
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
