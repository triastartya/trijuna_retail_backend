<?php
use App\Http\Controllers\Master\barangController;
use App\Http\Controllers\Master\barangKomponenController;
use App\Http\Controllers\Master\barangRakController;
use App\Http\Controllers\Master\barangSatuanController;
use App\Http\Controllers\Master\barangUraiController;
use Illuminate\Support\Facades\Route;

    Route::pointResource('barang',barangController::class);
    Route::post('barang/by_param',[barangController::class,'barang_by_param']);
    Route::pointResource('barang_rak',barangRakController::class);
    Route::get('barang_rak/by_id_barang/{id_barang}',[barangRakController::class,'by_id_barang']);
    Route::get('barang_rak/by_id_rak/{id_rak}',[barangRakController::class,'by_id_rak']);
    Route::pointResource('barang_satuan',barangSatuanController::class);
    Route::get('barang_satuan/by_id_barang/{id_barang}',[barangSatuanController::class,'by_id_barang']);
    Route::pointResource('barang_komponen',barangKomponenController::class);
    Route::get('barang_komponen/by_id_barang/{id_barang}',[barangKomponenController::class,'by_id_barang']);
    Route::pointResource('barang_urai',barangUraiController::class);
    Route::get('barang_urai/by_id_barang/{id_barang}',[barangUraiController::class,'by_id_barang']);