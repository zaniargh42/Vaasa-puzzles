<?php

namespace App\Http\Controllers;

use App\Models\City;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'cityCount' => City::query()->where('is_active', true)->count(),
        ]);
    }
}
