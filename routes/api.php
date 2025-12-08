<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::get('/products',        [ProductController::class, 'index']);
Route::post('/products',       [ProductController::class, 'store']);
Route::get('/products/{id}',   [ProductController::class, 'show']);
Route::put('/products/{id}',   [ProductController::class, 'update']);
Route::delete('/products/{id}',[ProductController::class, 'destroy']);
