<?php

namespace App\Services;

use App\Models\Game;
use App\Support\StageLocations;

class Stage1PuzzleService
{
    public function __construct(
        private GameBagService $bag,
    ) {}

    public function config(): array
    {
        return config('puzzles.stage1_setterberg');
    }

    public function itemDefinition(): array
    {
        $item = $this->config()['item'];

        return [
            ...$item,
            'label_key' => 'bag.items.setterberg_plan',
        ];
    }

    public function hasMap(Game $game): bool
    {
        return $this->bag->has($game, $this->itemDefinition()['id']);
    }

    public function collectMap(Game $game): void
    {
        $this->bag->add($game, $this->itemDefinition());
    }

    public function isAligned(Game $game): bool
    {
        return (bool) session($this->alignedKey($game), false);
    }

    public function markAligned(Game $game): void
    {
        session([$this->alignedKey($game) => true]);

        $config = $this->config();

        $this->bag->add($game, [
            ...$this->itemDefinition(),
            'type' => 'map_overlay',
            'label_key' => 'bag.items.setterberg_plan_aligned',
            'placement' => $config['target'],
            'map' => $config['map'],
            'locked' => true,
            'markers' => StageLocations::stage1ResolvedMarkers(),
        ]);
    }

    public function reset(Game $game): void
    {
        session()->forget($this->alignedKey($game));
    }

    public function placementMatches(array $placement): bool
    {
        $target = $this->config()['target'];
        $tolerance = $this->config()['tolerance'];

        $centerDistance = $this->haversineMeters(
            (float) $placement['center_lat'],
            (float) $placement['center_lng'],
            (float) $target['center_lat'],
            (float) $target['center_lng'],
        );

        if ($centerDistance > (float) $tolerance['center_meters']) {
            return false;
        }

        $rotationDelta = abs($this->normalizeAngle(
            (float) $placement['rotation_deg'] - (float) $target['rotation_deg'],
        ));

        if ($rotationDelta > (float) $tolerance['rotation_deg']) {
            return false;
        }

        $targetWidth = (float) $target['width_meters'];
        $widthRatio = abs(((float) $placement['width_meters'] - $targetWidth) / $targetWidth);

        return $widthRatio <= (float) $tolerance['width_ratio'];
    }

    public function clientConfig(Game $game): array
    {
        $config = $this->config();

        $aligned = $this->isAligned($game);

        return [
            'image' => $config['item']['image'],
            'map' => $config['map'],
            'initial' => $config['initial'],
            'has_map' => $this->hasMap($game),
            'aligned' => $aligned,
            'target' => $config['target'],
            'tolerance' => $config['tolerance'],
            'markers' => $aligned ? StageLocations::stage1ResolvedMarkers() : [],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function presentBagItems(Game $game): array
    {
        $markers = StageLocations::stage1ResolvedMarkers();

        return array_map(function (array $item) use ($markers) {
            if (
                ($item['id'] ?? null) === 'setterberg-plan'
                && (($item['type'] ?? null) === 'map_overlay' || ($item['locked'] ?? false))
            ) {
                $item['type'] = 'map_overlay';
                $item['markers'] = $markers;
            }

            return $item;
        }, $this->bag->items($game));
    }

    private function alignedKey(Game $game): string
    {
        return 'game_puzzle.'.$game->id.'.stage1_aligned';
    }

    private function haversineMeters(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return 2 * $earthRadius * asin(min(1, sqrt($a)));
    }

    private function normalizeAngle(float $degrees): float
    {
        $normalized = fmod($degrees + 180, 360);

        if ($normalized < 0) {
            $normalized += 360;
        }

        return $normalized - 180;
    }
}
