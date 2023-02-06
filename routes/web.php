<?php

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

Route::get('/fruit', [\App\Http\Controllers\FruitController::class, 'fruitIndex']);
Route::post('/updateFruitTable', [\App\Http\Controllers\FruitController::class, 'createFruit']);
Route::post('/removeFruit', [\App\Http\Controllers\FruitController::class, 'removeFruit']);
Route::get('/getJsonFruit', [\App\Http\Controllers\FruitController::class, 'getJsonFruit']);


