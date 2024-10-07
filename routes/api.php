<?php

use App\Actions\CancelRide;
use App\Actions\CreateRide;
use Illuminate\Support\Facades\Route;

Route::prefix('rides')->group(function () {
    Route::post('/', CreateRide::class);
    Route::prefix('/{id}')->group(function() {
        Route::patch('/cancel', CancelRide::class);
    });

});
 