<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'game_id',
        'order',
        'act',
        'location',
        'title',
        'intro_text',
        'code',
        'code_alternatives',
        'next_destination',
    ];

    protected function casts(): array
    {
        return [
            'location' => 'array',
            'title' => 'array',
            'intro_text' => 'array',
            'next_destination' => 'array',
            'code_alternatives' => 'array',
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function toLocalizedArray(?string $locale = null): array
    {
        $nextDestination = $this->translate('next_destination', $locale);

        return [
            'order' => $this->order,
            'act' => $this->act,
            'location' => $this->translate('location', $locale),
            'title' => $this->translate('title', $locale),
            'intro_text' => $this->translate('intro_text', $locale),
            'code' => $this->code,
            'next_destination' => $nextDestination,
        ];
    }
}
