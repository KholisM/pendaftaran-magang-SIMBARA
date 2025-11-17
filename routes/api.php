<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LamaranController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BiodataController;

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/biodata', [BiodataController::class, 'getBiodata']);
    Route::post('/biodata', [BiodataController::class, 'createBiodata']); 
    Route::put('/biodata/update', [BiodataController::class, 'updateBiodata']);
    Route::get('/biodata/edit', [BiodataController::class, 'editBiodata']);
    
    Route::post('/logout', LogoutController::class);
    Route::get('/user', [UserController::class, 'profile']);

    Route::get('/lamaran', [LamaranController::class, 'show']);
    Route::post('/lamaran', [LamaranController::class, 'store']);
    Route::put('/lamaran/{id}', [LamaranController::class, 'update']);
    Route::delete('/lamaran/{id}', [LamaranController::class, 'destroy']);
});
