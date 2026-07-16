<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Game;
use App\Services\GameBagService;
use App\Services\GameProgressService;
use App\Services\Stage1PuzzleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GameBagController extends Controller
{
    public function __construct(
        private GameProgressService $progress,
        private GameBagService $bag,
        private Stage1PuzzleService $stage1,
    ) {}

    public function collectSetterberg(City $city, Game $game): RedirectResponse
    {
        $this->ensurePlayable($city, $game);

        $this->stage1->collectMap($game);

        return back();
    }

    public function alignSetterberg(Request $request, City $city, Game $game): RedirectResponse
    {
        $this->ensurePlayable($city, $game);

        abort_unless($this->stage1->hasMap($game), 403);

        $validated = $request->validate([
            'center_lat' => ['required', 'numeric', 'between:-90,90'],
            'center_lng' => ['required', 'numeric', 'between:-180,180'],
            'rotation_deg' => ['required', 'numeric', 'between:-360,360'],
            'width_meters' => ['required', 'numeric', 'min:100', 'max:20000'],
        ]);

        if (! $this->stage1->placementMatches($validated)) {
            return back()->withErrors([
                'alignment' => __('app.stage1.align_fail'),
            ]);
        }

        $this->stage1->markAligned($game);

        return back();
    }

    private function ensurePlayable(City $city, Game $game): void
    {
        abort_unless($game->city_id === $city->id && $game->is_active, 404);
        abort_unless($this->progress->isStarted($game), 403);
    }
}
