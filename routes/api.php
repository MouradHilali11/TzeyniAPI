<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfessionalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('professional/')->group(function () {
    Route::post('register', [ProfessionalController::class, 'register'])->name('professional.register');
    Route::post('login', [ProfessionalController::class, 'login'])->name('professional.login');
    Route::post('logout', [ProfessionalController::class, 'logout'])->name('professional.logout');
    Route::post('verify-email', [ProfessionalController::class, 'verifyEmail'])->name('professional.verifyEmail');
});
