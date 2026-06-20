<?php

use App\Http\Controllers\BracketController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\ImportChart;
use App\Http\Controllers\ItemSelect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/import-chart', [ImportChart::class, 'import'])->name('import_chart');
Route::get('/martial', [ItemSelect::class, 'martial'])->name('martial');
Route::get('/tournament', [ItemSelect::class, 'tournament'])->name('tournament');
Route::get('/category', [ItemSelect::class, 'category'])->name('category');
Route::post('/category/rename', [ItemSelect::class, 'renameCategory'])->name('category_rename');

Route::get('/game/list', [GamesController::class, 'list'])->name('game_list');
Route::get('/game/detail', [GamesController::class, 'detail'])->name('game_detail');
Route::post('/game/edit', [GamesController::class, 'edit'])->name('game_edit');
Route::post('/game/create', [GamesController::class, 'create'])->name('game_create');
Route::get('/game/delete', [GamesController::class, 'delete'])->name('game_delete');
Route::post('/game/play', [GamesController::class, 'play'])->name('game_play');
Route::post('/game/save', [GamesController::class, 'save'])->name('game_save');

Route::get('/bracket', [BracketController::class, 'bracket'])->name('bracket');
Route::get('/bracket/detail', [BracketController::class, 'detail'])->name('bracket_detail');
Route::post('/save-bracket', [BracketController::class, 'saveBracket'])->name('bracket_save');
Route::post('/edit-bracket', [BracketController::class, 'editBracket'])->name('bracket_edit');
Route::post('/tournament/delete', [ItemSelect::class, 'deleteTournament'])->name('tournament_delete');
Route::get('/tournament/participants', [GamesController::class, 'participants'])->name('tournament_participants');
Route::get('/tournament/detail', [ItemSelect::class, 'tournamentDetail'])->name('tournament_detail');
