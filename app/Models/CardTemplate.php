<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'front_design',
        'back_design',
        'width',
        'height',
        'front_fields',
        'back_fields',
        'is_active'
    ];

    protected $casts = [
        'front_fields' => 'array',
        'back_fields' => 'array',
        'is_active' => 'boolean'
    ];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function getFrontDesignUrlAttribute(): ?string
    {
        return $this->front_design ? asset('storage/' . $this->front_design) : null;
    }

    public function getBackDesignUrlAttribute(): ?string
    {
        return $this->back_design ? asset('storage/' . $this->back_design) : null;
    }
}
