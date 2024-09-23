<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfessionalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('professional/')->group(function(){
    Route::post('register',[ProfessionalController::class,'register']);
    Route::post('login',[ProfessionalController::class,'login']);
});
