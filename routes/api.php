<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', \App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', \App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', \App\Http\Controllers\Api\LogoutController::class)->name('login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'level', 'middleware' => ['auth:api']], function () {
    Route::get('/', [\App\Http\Controllers\Api\LevelController::class, 'list'])->name('level.list');
    Route::post('/', [\App\Http\Controllers\Api\LevelController::class, 'store'])->name('level.store');
    Route::put('/{id}', [\App\Http\Controllers\Api\LevelController::class, 'update'])->name('level.update');
    Route::delete('/{id}', [\App\Http\Controllers\Api\LevelController::class, 'destroy'])->name('level.destroy');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
    Route::get('/', [\App\Http\Controllers\Api\UserController::class, 'list'])->name('user.list');
    Route::post('/', [\App\Http\Controllers\Api\UserController::class, 'store'])->name('user.store');
    Route::put('/{id}', [\App\Http\Controllers\Api\UserController::class, 'update'])->name('user.update');
    Route::delete('/{id}', [\App\Http\Controllers\Api\UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/me', [\App\Http\Controllers\Api\UserController::class, 'me'])->name('user.me');
});

Route::group(['prefix' => 'barang', 'middleware' => ['auth:api']], function () {
    Route::get('/', [\App\Http\Controllers\Api\BarangController::class, 'list'])->name('barang.list');
    Route::post('/', [\App\Http\Controllers\Api\BarangController::class, 'store'])->name('barang.store');
    Route::post('/{id}', [\App\Http\Controllers\Api\BarangController::class, 'update'])->name('barang.update');
    Route::delete('/{id}', [\App\Http\Controllers\Api\BarangController::class, 'destroy'])->name('barang.destroy');
});

Route::group(['prefix' => 'kategori', 'middleware' => ['auth:api']], function () {
    Route::get('/', [\App\Http\Controllers\Api\KategoriController::class, 'list'])->name('kategori.list');
    Route::post('/', [\App\Http\Controllers\Api\KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/{id}', [\App\Http\Controllers\Api\KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [\App\Http\Controllers\Api\KategoriController::class, 'destroy'])->name('kategori.destroy');
});

Route::group(['prefix' => 'penjualan', 'middleware' => ['auth:api']], function () {
    // Route::get('/', [\App\Http\Controllers\Api\KategoriController::class, 'list'])->name('kategori.list');
    Route::post('/', [\App\Http\Controllers\Api\PenjualanController::class, 'store'])->name('penjualan.store');
    // Route::put('/{id}', [\App\Http\Controllers\Api\KategoriController::class, 'update'])->name('kategori.update');
    // Route::delete('/{id}', [\App\Http\Controllers\Api\KategoriController::class, 'destroy'])->name('kategori.destroy');
});
