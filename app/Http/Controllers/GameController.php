<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Game;
use App\Services\GameProgressService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    public function __construct(
        private GameProgressService $progress,
    ) {}

    public function show(City $city, Game $game): Response|RedirectResponse
    {
        $this->ensureGameBelongsToCity($city, $game);

        if ($this->progress->isStarted($game) && ! $this->progress->isCompleted($game)) {
            return redirect()->route('stages.show', [
                'city' => $city,
                'game' => $game,
                'stage' => $this->progress->currentStageOrder($game),
            ]);
        }

        if ($this->progress->isCompleted($game)) {
            return redirect()->route('games.complete', [
                'city' => $city,
                'game' => $game,
            ]);
        }

        return Inertia::render('Games/Show', [
            'city' => $city->toLocalizedArray(),
            'game' => $game->toLocalizedArray(),
        ]);
    }

    public function start(City $city, Game $game): RedirectResponse
    {
        $this->ensureGameBelongsToCity($city, $game);

        $this->progress->start($game);

        return redirect()->route('stages.show', [
            'city' => $city,
            'game' => $game,
            'stage' => 1,
        ]);
    }

    public function complete(City $city, Game $game): Response|RedirectResponse
    {
        $this->ensureGameBelongsToCity($city, $game);

        if (! $this->progress->isCompleted($game)) {
            return redirect()->route('games.show', [
                'city' => $city,
                'game' => $game,
            ]);
        }

        return Inertia::render('Games/Complete', [
            'city' => $city->toLocalizedArray(),
            'game' => $game->toLocalizedArray(),
        ]);
    }

    public function reset(City $city, Game $game): RedirectResponse
    {
        $this->ensureGameBelongsToCity($city, $game);

        $this->progress->reset($game);

        return redirect()->route('games.show', [
            'city' => $city,
            'game' => $game,
        ]);
    }

    private function ensureGameBelongsToCity(City $city, Game $game): void
    {
        abort_unless($game->city_id === $city->id && $game->is_active, 404);
    }
}
