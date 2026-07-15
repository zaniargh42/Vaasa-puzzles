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
            ->orderBy('slug')
            ->get()
            ->map(fn (City $city) => [
                ...$city->toLocalizedArray(),
                'games_count' => $city->games_count,
            ]);

        return Inertia::render('Cities/Index', [
            'cities' => $cities,
        ]);
    }

    public function show(City $city): Response
    {
        abort_unless($city->is_active, 404);

        $city->load(['activeGames' => fn ($query) => $query->orderBy('slug')]);

        return Inertia::render('Cities/Show', [
            'city' => $city->toLocalizedArray(),
            'games' => $city->activeGames->map(fn (Game $game) => $game->toLocalizedArray()),
        ]);
    }
}
