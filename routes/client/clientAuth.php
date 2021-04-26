<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\LoginController;

Route::get('/client/login', [LoginController::class, 'index']);
Route::get('/client/password/forgot', [LoginController::class, 'forgotPassword']);
Route::post('/client/login', [LoginController::class, 'login']);
Route::post('/client/password/email', [LoginController::class, 'forgotPasswordEmail']);

Route::get('/client/password/reset/{token}', [LoginController::class, 'passwordReset']);
Route::post('/client/password/update', [LoginController::class, 'setNewPassword']);

