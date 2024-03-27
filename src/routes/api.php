<?php

use App\Http\Controllers\Api\MeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum', 'as' => 'api.'], function () {
    Route::get('/me', [MeController::class, 'index'])->name('me.index');
});
