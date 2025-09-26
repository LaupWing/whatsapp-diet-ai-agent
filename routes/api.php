<?php

use App\Http\Controllers\MealsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('user.public')->group(function () {
    Route::prefix('diet')->group(function () {
        Route::get('/macros/today', [MealsController::class, 'macrosToday']);
        Route::get('/meals/today', [MealsController::class, 'today']);
        // POST /diet/food_entries
        Route::post('/food_entries', [MealsController::class, 'store']);
    });
});
