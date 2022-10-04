<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
/** Controller */

Route::group(["prefix" => "contact"], function () {
    /** Private Routes */
    Route::group(["middleware" => ["auth:sanctum"]], function () {
        Route::get("/{id}", [ContactController::class, "show"]);
        Route::post("/", [ContactController::class, "store"]);
        Route::delete("/{id}", [ContactController::class, "destroy"]);
    });
});
