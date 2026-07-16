<?php

namespace App\Services;

use App\Models\Game;

class GameBagService
{
    private const SESSION_PREFIX = 'game_bag.';

    public function items(Game $game): array
    {
        $items = session($this->sessionKey($game), []);

        return array_values(is_array($items) ? $items : []);
    }

    public function has(Game $game, string $itemId): bool
    {
        foreach ($this->items($game) as $item) {
            if (($item['id'] ?? null) === $itemId) {
                return true;
            }
        }

        return false;
    }

    public function add(Game $game, array $item): void
    {
        $items = session($this->sessionKey($game), []);

        if (! is_array($items)) {
            $items = [];
        }

        $existing = $items[$item['id']] ?? [];

        $items[$item['id']] = [
            ...$existing,
            ...$item,
            'id' => $item['id'],
            'type' => $item['type'] ?? ($existing['type'] ?? 'item'),
            'image' => $item['image'] ?? ($existing['image'] ?? null),
            'label_key' => $item['label_key'] ?? ($existing['label_key'] ?? null),
            'acquired_at' => $existing['acquired_at'] ?? now()->toIso8601String(),
        ];

        session([$this->sessionKey($game) => $items]);
    }

    public function reset(Game $game): void
    {
        session()->forget($this->sessionKey($game));
    }

    private function sessionKey(Game $game): string
    {
        return self::SESSION_PREFIX.$game->id;
    }
}
