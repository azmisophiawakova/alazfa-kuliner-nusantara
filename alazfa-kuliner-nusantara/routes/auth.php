<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Halaman Pemilihan Peran (Bypass guest middleware)
Route::get('register', function () {
    return view('auth.register-role');
})->name('register');

// Pelanggan
Route::get('register/pelanggan', [\App\Http\Controllers\Auth\PelangganRegisterController::class, 'create'])->name('register.pelanggan');
Route::post('register/pelanggan', [\App\Http\Controllers\Auth\PelangganRegisterController::class, 'store']);

// Penjual
Route::get('register/penjual', [\App\Http\Controllers\Auth\PenjualRegisterController::class, 'create'])->name('register.penjual');
Route::post('register/penjual', [\App\Http\Controllers\Auth\PenjualRegisterController::class, 'store']);

// Kurir
Route::get('register/kurir', [\App\Http\Controllers\Auth\KurirRegisterController::class, 'create'])->name('register.kurir');
Route::post('register/kurir', [\App\Http\Controllers\Auth\KurirRegisterController::class, 'store']);

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
