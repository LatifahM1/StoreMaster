<?php

use Illuminate\Support\Facades\Route;

Route::get('/index', function () {
    return view('index');
});


Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/forgot', function () {
    return view('forgot');
});

Route::get('/reset', function () {
    return view('reset');
});

Route::get('/dashboard', function () {
    return view('product');
});

Route::get('/add', function () {
    return view('add');
});

Route::get('/edit', function () {
    return view('edit');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/product', function () {
    $productId = request()->query('id');
    return view('product.show', ['product_id' => $productId]);
})->name('product.show');