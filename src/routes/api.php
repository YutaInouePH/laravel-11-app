<?php

use App\Http\Controllers\Api\MeController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/me', [MeController::class, 'index'])->name('me.index');
    });
});
