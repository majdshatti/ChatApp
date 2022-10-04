<?php

use Illuminate\Support\Facades\Route;
/** Controllers */
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/** Public routes */
Route::post('/register', [RegisterController::class, 'index']);
Route::post('/login', [LoginController::class, 'index']);
