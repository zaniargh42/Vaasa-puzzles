<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'city_id',
        'slug',
        'title_fa',
        'title_en',
        'subtitle_fa',
        'description_fa',
        'stage_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
