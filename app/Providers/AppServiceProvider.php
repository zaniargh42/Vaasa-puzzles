<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Game;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Route::bind('game', function (string $value, $route) {
            $city = $route->parameter('city');

            if (! $city instanceof City) {
                $city = City::query()->where('slug', $city)->firstOrFail();
            }

            return Game::query()
                ->where('slug', $value)
                ->where('city_id', $city->id)
                ->firstOrFail();
        });
    }
}
