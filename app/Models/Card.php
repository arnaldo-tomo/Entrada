<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'card_template_id',
        'serial_number',
        'verification_token',
        'qr_code_path',
        'issued_date',
        'expiry_date',
        'status',
        'revoked_at',
        'revoked_reason'
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',
        'revoked_at' => 'datetime'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function cardTemplate(): BelongsTo
    {
        return $this->belongsTo(CardTemplate::class);
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class);
    }

    public function getQrCodeUrlAttribute(): ?string
    {
        return $this->qr_code_path ? asset('storage/' . $this->qr_code_path) : null;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }

    public function isValid(): bool
    {
        return $this->status === 'active' && !$this->isExpired();
    }

    public function getVerificationUrlAttribute(): string
    {
        return route('card.verify', $this->verification_token);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($card) {
            $card->serial_number = static::generateSerialNumber();
            $card->verification_token = static::generateVerificationToken();
        });

        static::updating(function ($card) {
            if ($card->isDirty('expiry_date') && $card->expiry_date->isPast()) {
                $card->status = 'expired';
            }
        });
    }

    public static function generateSerialNumber(): string
    {
        do {
            $serial = 'CID' . now()->format('Y') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::where('serial_number', $serial)->exists());

        return $serial;
    }

    public static function generateVerificationToken(): string
    {
        do {
            $token = bin2hex(random_bytes(16));
        } while (static::where('verification_token', $token)->exists());

        return $token;
    }
}
