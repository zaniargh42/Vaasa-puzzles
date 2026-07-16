<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Game;
use App\Models\Stage;
use Database\Seeders\GameContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GameFlowTest extends TestCase
{
    use RefreshDatabase;

    private City $city;

    private Game $game;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(GameContentSeeder::class);

        $this->city = City::query()->where('slug', 'vaasa')->firstOrFail();
        $this->game = Game::query()->where('slug', 'twelve-barrels')->firstOrFail();
    }

    #[Test]
    public function home_page_is_available(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Home'));
    }

    #[Test]
    public function cities_and_games_can_be_browsed(): void
    {
        $this->get(route('cities.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Cities/Index')
                ->has('cities', 1));

        $this->get(route('cities.show', $this->city))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Cities/Show')
                ->has('games', 1));

        $this->get(route('games.show', [$this->city, $this->game]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Games/Show'));
    }

    #[Test]
    public function stage_one_map_can_be_added_to_bag_and_aligned(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]));

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 1]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('stage.code', null)
                ->where('stage.next_destination', null)
                ->where('code_unlocked', false)
                ->where('stage1.has_map', false)
                ->has('directions'));

        $this->post(route('bag.collect-setterberg', [$this->city, $this->game]))
            ->assertRedirect();

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 1]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('stage1.has_map', true)
                ->has('bag', 1));

        $this->post(
            route('puzzles.stage1.align', [$this->city, $this->game]),
            config('puzzles.stage1_setterberg.target'),
        )->assertRedirect();

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 1]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('code_unlocked', true)
                ->where('stage.code', 'VANKILA')
                ->where('stage1.aligned', true)
                ->where('stage.next_destination', 'زندان واسا')
                ->where('stage.puzzle_note', null)
                ->has('stage1.markers', 2)
                ->where('bag.0.type', 'map_overlay')
                ->has('bag.0.markers', 2));
    }

    #[Test]
    public function player_can_progress_through_stages_with_codes(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]))
            ->assertRedirect(route('stages.show', [$this->city, $this->game, 'stage' => 1]));

        $this->completeStageOnePuzzle();

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 1]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Stages/Show')
                ->where('stage.order', 1)
                ->where('stage.code', 'VANKILA')
                ->where('navigation.previous_stage', null)
                ->where('stage.puzzle_note', null));

        $this->post(route('stages.submit', [$this->city, $this->game, 'stage' => 1]), [
            'code' => 'VANKILA',
        ])->assertRedirect(route('stages.show', [$this->city, $this->game, 'stage' => 2]));

        $this->post(route('stages.submit', [$this->city, $this->game, 'stage' => 2]), [
            'code' => 'wrong',
        ])->assertSessionHasErrors('code');

        $this->post(route('stages.submit', [$this->city, $this->game, 'stage' => 2]), [
            'code' => 'VALO',
        ])->assertRedirect(route('stages.show', [$this->city, $this->game, 'stage' => 3]));
    }

    #[Test]
    public function previous_stages_can_be_reviewed(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]));
        $this->completeStageOnePuzzle();

        $this->post(route('stages.submit', [$this->city, $this->game, 'stage' => 1]), [
            'code' => 'VANKILA',
        ]);

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 1]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('navigation.previous_stage', null)
                ->where('navigation.next_stage', 2)
                ->where('navigation.is_review', true));

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 2]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('navigation.previous_stage', 1)
                ->where('navigation.next_stage', null)
                ->where('navigation.is_review', false));
    }

    #[Test]
    public function future_stages_are_locked_until_reached(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]));

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 3]))
            ->assertForbidden();
    }

    #[Test]
    public function locale_can_be_switched(): void
    {
        $this->post(route('locale.update'), ['locale' => 'fi'])
            ->assertRedirect();

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where('locale', 'fi'));
    }

    #[Test]
    public function localized_content_follows_selected_locale(): void
    {
        $this->post(route('locale.update'), ['locale' => 'en']);

        $this->get(route('cities.show', $this->city))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('city.name', 'Vaasa')
                ->where('games.0.title', 'Twelve Barrels: The Hidden Grain of Nikolaistad'));
    }

    #[Test]
    public function map_calibrator_is_available_in_local(): void
    {
        $this->get(route('dev.map-calibrator'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Dev/MapCalibrator'));
    }

    #[Test]
    public function completing_final_stage_shows_completion_page(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]));
        $this->completeStageOnePuzzle();

        $stages = Stage::query()
            ->where('game_id', $this->game->id)
            ->orderBy('order')
            ->get();

        foreach ($stages as $stage) {
            $response = $this->post(route('stages.submit', [
                $this->city,
                $this->game,
                'stage' => $stage->order,
            ]), [
                'code' => $stage->code,
            ]);

            if ($stage->order === $stages->count()) {
                $response->assertRedirect(route('games.complete', [$this->city, $this->game]));
            } else {
                $response->assertRedirect(route('stages.show', [
                    $this->city,
                    $this->game,
                    'stage' => $stage->order + 1,
                ]));
            }
        }

        $this->get(route('games.complete', [$this->city, $this->game]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Games/Complete'));
    }

    private function completeStageOnePuzzle(): void
    {
        $this->post(route('bag.collect-setterberg', [$this->city, $this->game]));
        $this->post(
            route('puzzles.stage1.align', [$this->city, $this->game]),
            config('puzzles.stage1_setterberg.target'),
        );
    }
}
