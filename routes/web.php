<?php

use App\Http\Controllers\Auth\RegisteredController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisteredController::class, 'index'])->name('register.index');
Route::get('/register/verify/{token}', [RegisteredController::class, 'verify'])->name('register.verify');

