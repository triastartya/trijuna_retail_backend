<?php

use App\Http\Controllers\Pembelian\penerimaanDenganPOController;
use Illuminate\Support\Facades\Route;

Route::prefix('penerimaan_dengan_po')->group(function(){
        Route::post('lookup_pemesanan',[penerimaanDenganPOController::class,'lookup_pemesanan']);
        Route::post('lookup_barang/{id_pemesanan}',[penerimaanDenganPOController::class,'lookup_barang']);
        Route::post('insert',[penerimaanDenganPOController::class,'insert']);
        Route::post('get_by_param',[penerimaanDenganPOController::class,'get_by_param']);
        Route::get('get_by_id/{id_penerimaan}',[penerimaanDenganPOController::class,'get_by_id']);
        Route::post('validasi',[penerimaanDenganPOController::class,'validasi']);
    });