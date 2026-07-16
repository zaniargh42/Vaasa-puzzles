<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stage 1 — Setterberg plan overlay
    |--------------------------------------------------------------------------
    |
    | Target calibrated via /dev/map-calibrator (approximate; shoreline differs).
    |
    */

    'item' => [
        'id' => 'setterberg-plan',
        'image' => '/game-assets/twelve-barrels/setterberg-plan.jpg',
        'type' => 'map',
    ],

    'map' => [
        'tile_url' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'attribution' => '&copy; OpenStreetMap',
        'default_zoom' => 15,
    ],

    'target' => [
        'center_lat' => 63.098215,
        'center_lng' => 21.6036415,
        'rotation_deg' => -111,
        'width_meters' => 2380,
    ],

    // Generous: old plan vs modern coastline is imperfect.
    'tolerance' => [
        'center_meters' => 300,
        'rotation_deg' => 30,
        'width_ratio' => 0.3,
    ],

    'initial' => [
        'center_lat' => 63.1024,
        'center_lng' => 21.6188,
        'rotation_deg' => -35,
        'width_meters' => 3100,
        'opacity' => 0.7,
    ],

];
