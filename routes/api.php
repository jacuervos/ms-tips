<?php


use App\Http\Controllers\TipController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.jwt')->group(function () {
    Route::apiResource('tips', TipController::class);
});
