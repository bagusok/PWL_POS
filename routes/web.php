<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Products;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Users;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [
    HomeController::class,
    'index'
]);

Route::get('/category/{slug}', [
    ProductsController::class,
    'category'
]);

Route::get('/user/{userId}/name/{name}', [
    UsersController::class,
    'index'
]);

Route::get('/orders', [
    OrdersController::class,
    'index'
]);
