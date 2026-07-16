<?php

namespace App\Support;

class StageLocations
{
    public static function forStage(int $order): ?array
    {
        $location = config("puzzles.stage_locations.{$order}");

        if (! is_array($location)) {
            return null;
        }

        return [
            'lat' => (float) $location['lat'],
            'lng' => (float) $location['lng'],
            'label_key' => $location['label_key'],
            'directions_url' => sprintf(
                'https://www.google.com/maps/dir/?api=1&destination=%s,%s',
                $location['lat'],
                $location['lng'],
            ),
        ];
    }

    /**
     * @return list<array{lat: float, lng: float, style: string, label_key: string}>
     */
    public static function stage1ResolvedMarkers(): array
    {
        $current = self::forStage(1);
        $next = self::forStage(2);

        $markers = [];

        if ($current) {
            $markers[] = [
                'lat' => $current['lat'],
                'lng' => $current['lng'],
                'style' => 'done',
                'label_key' => $current['label_key'],
            ];
        }

        if ($next) {
            $markers[] = [
                'lat' => $next['lat'],
                'lng' => $next['lng'],
                'style' => 'next',
                'label_key' => $next['label_key'],
            ];
        }

        return $markers;
    }
}
