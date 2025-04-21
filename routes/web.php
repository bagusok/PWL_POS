<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriCOntroller;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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

Route::pattern('id', '[0-9]+'); // localization


Route::get('/',  [
    WelcomeController::class,
    'index'
])->middleware('auth');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');


// ------------------
Route::group(['prefix' => 'supplier', 'middleware' => ['auth', 'authorize:ADM,MNG'],], function () {
    Route::get('/', [
        SupplierController::class,
        'index'
    ]);
    Route::post('/list', [
        SupplierController::class,
        'list'
    ]);
    Route::get('/create', [
        SupplierController::class,
        'create'
    ]);
    Route::post('/', [
        SupplierController::class,
        'store'
    ]);

    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [
        SupplierController::class,
        'edit_ajax'
    ]);
    Route::put('/{id}/update_ajax', [
        SupplierController::class,
        'update_ajax'
    ]);

    Route::get('/{id}/delete_ajax', [
        SupplierController::class,
        'confirm_ajax'
    ]);
    Route::delete('/{id}/delete_ajax', [
        SupplierController::class,
        'delete_ajax'
    ]);
    Route::get('/{id}', [
        SupplierController::class,
        'show'
    ]);
    Route::get('/{id}/edit', [
        SupplierController::class,
        'edit'
    ]);
    Route::put('/{id}', [
        SupplierController::class,
        'update'
    ]);
    Route::delete('/{id}', [
        SupplierController::class,
        'destroy'
    ]);

    Route::get('/import', [
        SupplierController::class,
        'import'
    ]);

    Route::post('/import_ajax', [
        SupplierController::class,
        'import_ajax'
    ]);

    Route::get('/export_excel', [
        SupplierController::class,
        'export_excel'
    ]);

    Route::get('/export_pdf', [
        SupplierController::class,
        'export_pdf'
    ]);
});

Route::group(['prefix' => 'level', 'middleware' => ['auth', 'authorize:ADM']], function () {
    Route::get('/', [
        LevelController::class,
        'index'
    ]);
    Route::post('/list', [
        LevelController::class,
        'list'
    ]);
    Route::get('/create', [
        LevelController::class,
        'create'
    ]);
    Route::post('/', [
        LevelController::class,
        'store'
    ]);

    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/ajax', [LevelController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [
        LevelController::class,
        'edit_ajax'
    ]);
    Route::put('/{id}/update_ajax', [
        LevelController::class,
        'update_ajax'
    ]);

    Route::get('/{id}/delete_ajax', [
        LevelController::class,
        'confirm_ajax'
    ]);
    Route::delete('/{id}/delete_ajax', [
        LevelController::class,
        'delete_ajax'
    ]);

    Route::get('/{id}', [
        LevelController::class,
        'show'
    ]);
    Route::get('/{id}/edit', [
        LevelController::class,
        'edit'
    ]);
    Route::put('/{id}', [
        LevelController::class,
        'update'
    ]);
    Route::delete('/{id}', [
        LevelController::class,
        'destroy'
    ]);

    Route::get('/import', [
        LevelController::class,
        'import'
    ]);

    Route::post('/import_ajax', [
        LevelController::class,
        'import_ajax'
    ]);

    Route::get('/export_excel', [
        LevelController::class,
        'export_excel'
    ]);

    Route::get('/export_pdf', [
        LevelController::class,
        'export_pdf'
    ]);
});

Route::group(['prefix' => 'kategori', 'middleware' => ['auth', 'authorize:ADM,MNG,STF']], function () {
    Route::get('/', [
        KategoriController::class,
        'index'
    ]);
    Route::post('/list', [
        KategoriController::class,
        'list'
    ]);
    Route::get('/create', [
        KategoriController::class,
        'create'
    ]);
    Route::post('/', [
        KategoriController::class,
        'store'
    ]);


    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [
        KategoriController::class,
        'edit_ajax'
    ]);
    Route::put('/{id}/update_ajax', [
        KategoriController::class,
        'update_ajax'
    ]);

    Route::get('/{id}/delete_ajax', [
        KategoriController::class,
        'confirm_ajax'
    ]);
    Route::delete('/{id}/delete_ajax', [
        KategoriController::class,
        'delete_ajax'
    ]);

    Route::get('/{id}', [
        KategoriController::class,
        'show'
    ]);
    Route::get('/{id}/edit', [
        KategoriController::class,
        'edit'
    ]);
    Route::put('/{id}', [
        KategoriController::class,
        'update'
    ]);
    Route::delete('/{id}', [
        KategoriController::class,
        'destroy'
    ]);

    Route::get('/import', [
        KategoriController::class,
        'import'
    ]);

    Route::post('/import_ajax', [
        KategoriController::class,
        'import_ajax'
    ]);

    Route::get('/export_excel', [
        KategoriController::class,
        'export_excel'
    ]);

    Route::get('/export_pdf', [
        KategoriController::class,
        'export_pdf'
    ]);
});


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'authorize:ADM'],], function () {
    Route::get('/', [
        UserController::class,
        'index'
    ]);
    Route::post('/list', [
        UserController::class,
        'list'
    ]);
    Route::get('/create', [
        UserController::class,
        'create'
    ]);

    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);

    Route::post('/', [
        UserController::class,
        'store'
    ]);
    Route::get('/{id}', [
        UserController::class,
        'show'
    ]);
    Route::get('/{id}/edit', [
        UserController::class,
        'edit'
    ]);

    Route::put('/{id}', [
        UserController::class,
        'update'
    ]);

    Route::get('/{id}/edit_ajax', [
        UserController::class,
        'edit_ajax'
    ]);
    Route::put('/{id}/update_ajax', [
        UserController::class,
        'update_ajax'
    ]);

    Route::get('/{id}/delete_ajax', [
        UserController::class,
        'confirm_ajax'
    ]);
    Route::delete('/{id}/delete_ajax', [
        UserController::class,
        'delete_ajax'
    ]);

    Route::delete('/{id}', [
        UserController::class,
        'destroy'
    ]);

    Route::get('/import', [
        UserController::class,
        'import'
    ]);

    Route::post('/import_ajax', [
        UserController::class,
        'import_ajax'
    ]);

    Route::get('/export_excel', [
        UserController::class,
        'export_excel'
    ]);

    Route::get('/export_pdf', [
        UserController::class,
        'export_pdf'
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/settings/change-profile-picture', [
        UserController::class,
        'change_profile_picture'
    ]);

    Route::post('/user/settings/change-profile-picture/update', [
        UserController::class,
        'update_profile_picture'
    ]);
});

Route::group(['prefix' => 'barang', 'middleware' => ['auth', 'authorize:ADM,MNG,STF']], function () {
    Route::get('/', [
        BarangController::class,
        'index'
    ]);
    Route::post('/list', [
        BarangController::class,
        'list'
    ]);
    Route::get('/create', [
        BarangController::class,
        'create'
    ]);
    Route::post('/', [
        BarangController::class,
        'store'
    ]);


    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/ajax', [BarangController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [
        BarangController::class,
        'edit_ajax'
    ]);
    Route::put('/{id}/update_ajax', [
        BarangController::class,
        'update_ajax'
    ]);

    Route::get('/{id}/delete_ajax', [
        BarangController::class,
        'confirm_ajax'
    ]);
    Route::delete('/{id}/delete_ajax', [
        BarangController::class,
        'delete_ajax'
    ]);


    Route::get('/{id}', [
        BarangController::class,
        'show'
    ]);
    Route::get('/{id}/edit', [
        BarangController::class,
        'edit'
    ]);
    Route::put('/{id}', [
        BarangController::class,
        'update'
    ]);
    Route::delete('/{id}', [
        BarangController::class,
        'destroy'
    ]);

    Route::get('/import', [
        BarangController::class,
        'import'
    ]);

    Route::post('/import_ajax', [
        BarangController::class,
        'import_ajax'
    ]);

    Route::get('/export_excel', [
        BarangController::class,
        'export_excel'
    ]);

    Route::get('/export_pdf', [
        BarangController::class,
        'export_pdf'
    ]);
});

Route::group(['prefix' => 'stock', 'middleware' => ['auth', 'authorize:ADM,MNG,STF']], function () {
    Route::get('/', [
        StockController::class,
        'index'
    ]);
    Route::post('/list', [
        StockController::class,
        'list'
    ]);

    Route::get('/create_ajax', [StockController::class, 'create_ajax']);
    Route::post('/ajax', [StockController::class, 'store_ajax']);

    Route::get('/{id}/delete_ajax', [
        StockController::class,
        'confirm_ajax'
    ]);

    Route::delete('/{id}/delete_ajax', [
        StockController::class,
        'delete_ajax'
    ]);
});

Route::group(['prefix' => 'penjualan', 'middleware' => ['auth', 'authorize:ADM,MNG,STF']], function () {
    Route::get('/', [
        PenjualanController::class,
        'index'
    ]);

    Route::post('/list', [
        PenjualanController::class,
        'list'
    ]);

    Route::get('/{id}/show_ajax', [
        PenjualanController::class,
        'show_ajax'
    ]);

    Route::get('/create', [
        PenjualanController::class,
        'create'
    ]);

    Route::post('/store', [
        PenjualanController::class,
        'store'
    ]);

    Route::get('/edit/{id}', [
        PenjualanController::class,
        'edit'
    ]);
    Route::post('/edit', [
        PenjualanController::class,
        'update'
    ]);

    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']);

    Route::get('/{id}/delete_ajax', [
        PenjualanController::class,
        'confirm_ajax'
    ]);

    Route::delete('/{id}/delete_ajax', [
        PenjualanController::class,
        'delete_ajax'
    ]);

    Route::get('/export_pdf', [
        PenjualanController::class,
        'export_pdf'
    ]);
});
