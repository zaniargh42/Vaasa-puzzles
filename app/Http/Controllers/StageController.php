<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Game;
use App\Models\Stage;
use App\Services\GameCodeValidator;
use App\Services\GameProgressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StageController extends Controller
{
    public function __construct(
        private GameProgressService $progress,
        private GameCodeValidator $codeValidator,
    ) {}

    public function show(City $city, Game $game, int $stage): Response|RedirectResponse
    {
        $this->ensureGameBelongsToCity($city, $game);

        if (! $this->progress->isStarted($game)) {
            return redirect()->route('games.show', [
                'city' => $city,
                'game' => $game,
            ]);
        }

        if ($this->progress->isCompleted($game)) {
            return redirect()->route('games.complete', [
                'city' => $city,
                'game' => $game,
            ]);
        }

        abort_unless($this->progress->canAccessStage($game, $stage), 403);

        $stageModel = $this->findStage($game, $stage);

        return Inertia::render('Stages/Show', [
            'city' => $city->only(['slug', 'name_fa']),
            'game' => $game->only(['slug', 'title_fa', 'stage_count']),
            'stage' => [
                'order' => $stageModel->order,
                'act' => $stageModel->act,
                'location_fa' => $stageModel->location_fa,
                'title_fa' => $stageModel->title_fa,
                'intro_text' => $stageModel->intro_text,
                'code' => $stageModel->code,
                'next_destination_fa' => $stageModel->next_destination_fa,
            ],
            'progress' => [
                'current' => $this->progress->currentStageOrder($game),
                'total' => $game->stage_count,
            ],
        ]);
    }

    public function submit(Request $request, City $city, Game $game, int $stage): RedirectResponse
    {
        $this->ensureGameBelongsToCity($city, $game);

        abort_unless($this->progress->canAccessStage($game, $stage), 403);

        $stageModel = $this->findStage($game, $stage);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:255'],
        ]);

        if (! $this->codeValidator->matches(
            $validated['code'],
            $stageModel->code,
            $stageModel->code_alternatives,
        )) {
            return back()->withErrors([
                'code' => 'رمز واردشده درست نیست.',
            ]);
        }

        $this->progress->advance($game, $stage);

        if ($this->progress->isCompleted($game)) {
            return redirect()->route('games.complete', [
                'city' => $city,
                'game' => $game,
            ]);
        }

        return redirect()->route('stages.show', [
            'city' => $city,
            'game' => $game,
            'stage' => $stage + 1,
        ]);
    }

    private function ensureGameBelongsToCity(City $city, Game $game): void
    {
        abort_unless($game->city_id === $city->id && $game->is_active, 404);
    }

    private function findStage(Game $game, int $order): Stage
    {
        return $game->stages()->where('order', $order)->firstOrFail();
    }
}
