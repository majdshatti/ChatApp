<?php

use Illuminate\Support\Facades\Route;
/** Controller */
use App\Http\Controllers\MessageController;

Route::group(["prefix" => "message"], function () {
    /** Private Routes */
    Route::group(["middleware" => ["auth:sanctum"]], function () {
        Route::get("/", [MessageController::class, "index"]);
        Route::post("/", [MessageController::class, "store"]);
    });
});
