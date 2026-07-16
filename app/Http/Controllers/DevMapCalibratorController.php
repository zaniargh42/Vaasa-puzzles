<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DevMapCalibratorController extends Controller
{
    public function __invoke(): Response
    {
        abort_unless(app()->environment(['local', 'testing']), 404);

        $config = config('puzzles.stage1_setterberg');

        return Inertia::render('Dev/MapCalibrator', [
            'image' => $config['item']['image'],
            'map' => $config['map'],
            'initial' => [
                ...$config['target'],
                'opacity' => 0.7,
            ],
            'target' => $config['target'],
            'tolerance' => $config['tolerance'],
        ]);
    }
}
