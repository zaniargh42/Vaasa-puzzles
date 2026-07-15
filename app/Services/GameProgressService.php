<?php

namespace App\Services;

use App\Models\Game;

class GameProgressService
{
    private const SESSION_PREFIX = 'game_progress.';

    public function start(Game $game): void
    {
        session([
            $this->sessionKey($game) => [
                'game_id' => $game->id,
                'current_stage_order' => 1,
                'completed' => false,
            ],
        ]);
    }

    public function currentStageOrder(Game $game): ?int
    {
        $progress = $this->progress($game);

        if ($progress === null) {
            return null;
        }

        if ($progress['completed']) {
            return $game->stage_count;
        }

        return $progress['current_stage_order'];
    }

    public function isStarted(Game $game): bool
    {
        return $this->progress($game) !== null;
    }

    public function isCompleted(Game $game): bool
    {
        $progress = $this->progress($game);

        return $progress !== null && ($progress['completed'] ?? false);
    }

    public function canAccessStage(Game $game, int $stageOrder): bool
    {
        $current = $this->currentStageOrder($game);

        if ($current === null) {
            return false;
        }

        if ($this->isCompleted($game)) {
            return $stageOrder <= $game->stage_count;
        }

        return $stageOrder <= $current;
    }

    public function advance(Game $game, int $completedStageOrder): void
    {
        $progress = $this->progress($game);

        if ($progress === null || $progress['current_stage_order'] !== $completedStageOrder) {
            return;
        }

        if ($completedStageOrder >= $game->stage_count) {
            session([
                $this->sessionKey($game) => [
                    ...$progress,
                    'current_stage_order' => $game->stage_count,
                    'completed' => true,
                ],
            ]);

            return;
        }

        session([
            $this->sessionKey($game) => [
                ...$progress,
                'current_stage_order' => $completedStageOrder + 1,
            ],
        ]);
    }

    public function reset(Game $game): void
    {
        session()->forget($this->sessionKey($game));
    }

    private function progress(Game $game): ?array
    {
        $progress = session($this->sessionKey($game));

        if (! is_array($progress) || ($progress['game_id'] ?? null) !== $game->id) {
            return null;
        }

        return $progress;
    }

    private function sessionKey(Game $game): string
    {
        return self::SESSION_PREFIX.$game->id;
    }
}
