<?php

use Illuminate\Support\Facades\Route;
/** Controllers */
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerifySocketController;

/** Public routes */
Route::post('/register', [RegisterController::class, 'index']);
Route::post('/login', [LoginController::class, 'index']);

/** Private routes */
Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('/verify/{userSentToId}', [VerifySocketController::class, 'index']);
});
