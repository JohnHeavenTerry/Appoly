<?php

use Illuminate\Support\Facades\Route;

Route::get('/pokedex', [\App\Http\Controllers\PokemonController::class, 'pokedexIndex']);
Route::get('/getPokemonData', [\App\Http\Controllers\PokemonController::class, 'getPokemonData']);
Route::get('/getPokemonFromApi', [\App\Http\Controllers\PokemonController::class, 'getPokemonFromApi']);


