<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\DevMapCalibratorController;
use App\Http\Controllers\GameBagController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StageController;
use Illuminate\Support\Facades\Route;

Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('/cities/{city}', [CityController::class, 'show'])->name('cities.show');

Route::get('/dev/map-calibrator', DevMapCalibratorController::class)
    ->name('dev.map-calibrator');

Route::prefix('/cities/{city}/games/{game}')->group(function () {
    Route::get('/', [GameController::class, 'show'])->name('games.show');
    Route::post('/start', [GameController::class, 'start'])->name('games.start');
    Route::get('/complete', [GameController::class, 'complete'])->name('games.complete');
    Route::post('/reset', [GameController::class, 'reset'])->name('games.reset');

    Route::post('/bag/setterberg-plan', [GameBagController::class, 'collectSetterberg'])
        ->name('bag.collect-setterberg');
    Route::post('/puzzles/stage1/align', [GameBagController::class, 'alignSetterberg'])
        ->name('puzzles.stage1.align');

    Route::get('/stages/{stage}', [StageController::class, 'show'])->name('stages.show');
    Route::post('/stages/{stage}', [StageController::class, 'submit'])->name('stages.submit');
});

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
