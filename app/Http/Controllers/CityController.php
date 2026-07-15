<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Game;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    public function index(): Response
    {
        $cities = City::query()
            ->where('is_active', true)
            ->withCount(['activeGames as games_count'])
            ->orderBy('name_fa')
            ->get(['id', 'slug', 'name_fa', 'name_en', 'description_fa']);

        return Inertia::render('Cities/Index', [
            'cities' => $cities,
        ]);
    }

    public function show(City $city): Response
    {
        abort_unless($city->is_active, 404);

        $city->load(['activeGames' => fn ($query) => $query->orderBy('title_fa')]);

        return Inertia::render('Cities/Show', [
            'city' => $city->only(['slug', 'name_fa', 'name_en', 'description_fa']),
            'games' => $city->activeGames->map(fn (Game $game) => [
                'slug' => $game->slug,
                'title_fa' => $game->title_fa,
                'title_en' => $game->title_en,
                'subtitle_fa' => $game->subtitle_fa,
                'description_fa' => $game->description_fa,
                'stage_count' => $game->stage_count,
            ]),
        ]);
    }
}
