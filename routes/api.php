<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function() {
    return response()->json(["message" => "It works"]);
});

Route::post('/register/store', [RegisteredController::class, 'store'])->name('register.store');
Route::post('/verify/user/token', [RegisteredController::class, 'verification'])->name('verify.user');
