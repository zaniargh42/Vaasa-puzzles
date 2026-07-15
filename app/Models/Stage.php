<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stage extends Model
{
    protected $fillable = [
        'game_id',
        'order',
        'act',
        'location_fa',
        'title_fa',
        'intro_text',
        'code',
        'code_alternatives',
        'next_destination_fa',
    ];

    protected function casts(): array
    {
        return [
            'code_alternatives' => 'array',
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
