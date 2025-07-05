<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyemail'])->name('verification.verify');
Route::post('/forgot-password', [AuthController::class, 'sendresetpassword'])->middleware('throttle:5,1');
Route::post('/reset-password', [AuthController::class, 'resetpassword']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/email/resend', [AuthController::class, 'resendverifyemail'])->middleware(['api', 'throttle:email-request']);
    Route::apiResource('profile', ProfileController::class)->middleware('verified');
    Route::post('/logout', [AuthController::class, 'logout']);
});