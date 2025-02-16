<?php

use App\Http\Controllers\{
    AuthController,
    TransactionController,
    UserController,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me')->name('me');
});

Route::prefix('users')->middleware('auth')->controller(UserController::class)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::put('/{id}/status', 'changeStatus');
    Route::delete('/{id}', 'destroy');
    Route::get('/wallet/balance', 'balance');
});

Route::prefix('transactions')->middleware('auth')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/deposit', 'deposit');
    Route::post('/subtract', 'subtract');
    Route::delete('/{id}', 'destroy');
});