<?php

use App\Http\Controllers\TestWeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::controller(TestWeatherController::class)->group(function () {
        Route::get('weather-api', 'weatherApi');
        Route::get('visual-crossing', 'visualCrossing');
        Route::get('open-meteo', 'openMeteo');
        Route::get('weather-bit', 'weatherBit');
    });
});
