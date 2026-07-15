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
    public function player_can_progress_through_stages_with_codes(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]))
            ->assertRedirect(route('stages.show', [$this->city, $this->game, 'stage' => 1]));

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 1]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Stages/Show')
                ->where('stage.order', 1)
                ->where('stage.code', 'VANKILA'));

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
    public function future_stages_are_locked_until_reached(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]));

        $this->get(route('stages.show', [$this->city, $this->game, 'stage' => 3]))
            ->assertForbidden();
    }

    #[Test]
    public function completing_final_stage_shows_completion_page(): void
    {
        $this->post(route('games.start', [$this->city, $this->game]));

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
}
