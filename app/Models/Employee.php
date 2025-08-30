<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identification_number',
        'department',
        'position',
        'photo',
        'email',
        'phone',
        'status'
    ];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function activeCard()
    {
        return $this->cards()->where('status', 'active')->latest()->first();
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-avatar.png');
    }
}
