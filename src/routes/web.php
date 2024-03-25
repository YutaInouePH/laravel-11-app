<?php

Route::post('/login', \App\Http\Controllers\LoginController::class)->name('login');
Route::post('/logout', \App\Http\Controllers\LogoutController::class)->name('logout');
