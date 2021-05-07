<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\HistoryController;

Route::post('login', [LoginController::class,'login']);

Route::group(['middleware' => ['jwt.verify:admin,owner,karyawan']], function () {
    Route::get('login/check', [LoginController::class,'loginCheck']);
    Route::post('logout', [LoginController::class,'logout']);
});

Route::group(['middleware' => ['jwt.verify:admin,owner']], function () {
   Route::get('karyawan/{limit}/{offset}', [KaryawanController::class,'getAll']); 
   Route::get('karyawan/{id}', [KaryawanController::class,'getById']); 
   Route::post('karyawan', [KaryawanController::class,'insert']); 
   Route::put('karyawan/{id_user}', [KaryawanController::class,'update']); 
   Route::delete('karyawan/{id_user}', [KaryawanController::class,'delete']);
});

Route::group(['middleware' => ['jwt.verify:admin,owner,karyawan']], function () {
   Route::get('supplier', [SupplierController::class,'getAll']); 
   Route::get('supplier/{limit}/{offset}', [SupplierController::class,'getAll']); 
   Route::get('supplier/{id}', [SupplierController::class,'getById']); 
   Route::post('supplier', [SupplierController::class,'insert']); 
   Route::put('supplier/{id_supplier}', [SupplierController::class,'update']); 
   Route::delete('supplier/{id_supplier}', [SupplierController::class,'delete']); 
   
   Route::get('pelanggan', [PelangganController::class,'getAll']); 
   Route::get('pelanggan/{limit}/{offset}', [PelangganController::class,'getAll']); 
   Route::get('pelanggan/{id}', [PelangganController::class,'getById']); 
   Route::post('pelanggan', [PelangganController::class,'insert']); 
   Route::put('pelanggan/{id_pelanggan}', [PelangganController::class,'update']); 
   Route::delete('pelanggan/{id_pelanggan}', [PelangganController::class,'delete']); 

   Route::get('stock/{limit}/{offset}', [StockController::class,'getAll']); 
   Route::get('stock/{id_stock}', [StockController::class,'getById']); 
   Route::get('stockSupplier/{id_supplier}', [StockController::class,'getByIdSupplier']); 
   Route::post('stock', [StockController::class,'insert']); 
   Route::put('stock/{id_stock}', [StockController::class,'update']); 
   Route::post('findStock/{limit}/{offset}', [StockController::class,'findStock']); 
   Route::delete('stock/{id_stock}', [StockController::class,'delete']); 

   Route::get('stockIn/{limit}/{offset}', [StockInController::class,'getAll']); 
   Route::post('stockIn', [StockInController::class,'insert']); 
   Route::put('stockIn/{id_stock}', [StockInController::class,'update']); 
   Route::delete('stockIn/{id_stock_in}', [StockInController::class,'delete']); 

   Route::get('stockOut/{limit}/{offset}', [StockOutController::class,'getAll']); 
   Route::post('stockOut', [StockOutController::class,'insert']); 
   Route::put('stockOut/{id_stock}', [StockOutController::class,'update']); 
   Route::delete('stockOut/{id_stock_in}', [StockOutController::class,'delete']); 

   //HISTORY
   // Route::post('sortHistory', [HistoryController::class,'sortBy']);
   // Route::post('sortHistory/{limit}/{offset}', [HistoryController::class,'sortBy']);
   // Route::get('getHistoryById/{id_history}', [HistoryController::class,'getHistoryById']);
   // Route::get('history/{type}', [HistoryController::class,'getHistory']);
   // Route::resource('history', HistoryController::class);
   Route::post('report', [HistoryController::class,'report']);
   Route::post('sortHistory', [HistoryController::class,'sortBy']);
   Route::post('sortHistory/{limit}/{offset}', [HistoryController::class,'sortBy']);
   Route::get('getHistoryById/{id_history}', [HistoryController::class,'getHistoryById']);
   Route::get('history/{type}', [HistoryController::class,'getHistory']);
   Route::get('history/{type}', [HistoryController::class,'getByType']);
   Route::resource('history', HistoryController::class);
});
