<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'slug',
        'name_fa',
        'name_en',
        'description_fa',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function activeGames(): HasMany
    {
        return $this->games()->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
