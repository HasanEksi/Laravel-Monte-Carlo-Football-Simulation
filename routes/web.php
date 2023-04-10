<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return Redirect::route('teams.index');
});

Route::resource('/teams', TeamController::class);

Route::resource('/fixtures', FixtureController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::resource('/matches', \App\Http\Controllers\MatchController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::resource('/league', LeagueController::class)->only(['index', 'store']);
Route::delete('/league/reset', [LeagueController::class, 'reset'])->name('league.reset');

require __DIR__ . '/auth.php';
