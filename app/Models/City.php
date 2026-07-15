<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
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

    public function toLocalizedArray(?string $locale = null): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->translate('name', $locale),
            'description' => $this->translate('description', $locale),
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
