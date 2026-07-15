<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Game;
use App\Models\Stage;
use Database\Seeders\Data\TwelveBarrelsContent;
use Illuminate\Database\Seeder;

class GameContentSeeder extends Seeder
{
    public function run(): void
    {
        $content = TwelveBarrelsContent::data();

        $city = City::query()->updateOrCreate(
            ['slug' => $content['city']['slug']],
            [
                'name' => $content['city']['name'],
                'description' => $content['city']['description'],
                'is_active' => $content['city']['is_active'],
            ],
        );

        $game = Game::query()->updateOrCreate(
            ['city_id' => $city->id, 'slug' => $content['game']['slug']],
            [
                'title' => $content['game']['title'],
                'subtitle' => $content['game']['subtitle'],
                'description' => $content['game']['description'],
                'stage_count' => $content['game']['stage_count'],
                'is_active' => $content['game']['is_active'],
            ],
        );

        Stage::query()->where('game_id', $game->id)->delete();

        foreach ($content['stages'] as $stage) {
            Stage::query()->create([
                'game_id' => $game->id,
                ...$stage,
            ]);
        }
    }
}
