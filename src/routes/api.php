<?php

use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], function () {
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/me', [MeController::class, 'index'])->name('me.index');

        Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    });
});
