<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json('Gerador de corridas API');
});
 