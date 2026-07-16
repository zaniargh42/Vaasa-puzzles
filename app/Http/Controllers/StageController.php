<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Game;
use App\Models\Stage;
use App\Services\GameBagService;
use App\Services\GameCodeValidator;
use App\Services\GameProgressService;
use App\Services\Stage1PuzzleService;
use App\Support\StageLocations;
use Database\Seeders\Data\TwelveBarrelsPuzzleNotes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StageController extends Controller
{
    public function __construct(
        private GameProgressService $progress,
        private GameCodeValidator $codeValidator,
        private GameBagService $bag,
        private Stage1PuzzleService $stage1,
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
        $currentStage = $this->progress->currentStageOrder($game);
        $stagePayload = $stageModel->toLocalizedArray();
        // Temporary puzzle notes: hide for stage 1 (live puzzle), keep for later stages.
        $stagePayload['puzzle_note'] = $stage === 1
            ? null
            : TwelveBarrelsPuzzleNotes::forStage($stage);

        $codeUnlocked = $stage !== 1 || $this->stage1->isAligned($game);

        if (! $codeUnlocked) {
            $stagePayload['code'] = null;
            $stagePayload['next_destination'] = null;
        }

        return Inertia::render('Stages/Show', [
            'city' => $city->toLocalizedArray(),
            'game' => $game->toLocalizedArray(),
            'stage' => $stagePayload,
            'progress' => [
                'current' => $currentStage,
                'total' => $game->stage_count,
            ],
            'navigation' => [
                'previous_stage' => $stage > 1 ? $stage - 1 : null,
                'next_stage' => $stage < $currentStage ? $stage + 1 : null,
                'is_review' => $stage < $currentStage,
            ],
            'bag' => $this->stage1->presentBagItems($game),
            'stage1' => $stage === 1 ? $this->stage1->clientConfig($game) : null,
            'code_unlocked' => $codeUnlocked,
            'directions' => StageLocations::forStage($stage),
        ]);
    }

    public function submit(Request $request, City $city, Game $game, int $stage): RedirectResponse
    {
        $this->ensureGameBelongsToCity($city, $game);

        abort_unless($this->progress->canAccessStage($game, $stage), 403);

        $currentStage = $this->progress->currentStageOrder($game);

        if ($stage < $currentStage) {
            return redirect()->route('stages.show', [
                'city' => $city,
                'game' => $game,
                'stage' => $stage,
            ]);
        }

        if ($stage === 1 && ! $this->stage1->isAligned($game)) {
            return back()->withErrors([
                'code' => __('app.stage1.code_locked'),
            ]);
        }

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
                'code' => __('app.stages.invalid_code'),
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
