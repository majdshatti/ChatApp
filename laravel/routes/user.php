<?php

use Illuminate\Support\Facades\Route;
/** Controller */
use App\Http\Controllers\UserController;

Route::group(["prefix" => "user"], function () {
    /** Private Routes */
    Route::group(["middleware" => ["auth:sanctum"]], function () {
        Route::get("/", [UserController::class, "index"]);
    });
});
