<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasTranslations;

    protected $fillable = [
        'city_id',
        'slug',
        'title',
        'subtitle',
        'description',
        'stage_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'subtitle' => 'array',
            'description' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class)->orderBy('order');
    }

    public function toLocalizedArray(?string $locale = null): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->translate('title', $locale),
            'subtitle' => $this->translate('subtitle', $locale),
            'description' => $this->translate('description', $locale),
            'stage_count' => $this->stage_count,
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
