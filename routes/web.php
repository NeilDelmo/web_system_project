<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Sale_OrderController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

//products route
Route::get('products', [ProductController::class, 'index'])->middleware('auth')->name('products');

//inventory route
Route::get('/inventory', [InventoryController::class, 'index'])->middleware('auth')->name('inventory'); 

//sale and order route
Route::get('/sale_and_orders', [Sale_OrderController::class, 'index'])->middleware('auth')->name('sale_and_orders');
