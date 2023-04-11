<?php
use App\Http\Controllers\Pembelian\penerimaanTanpaPOController;
use Illuminate\Support\Facades\Route;

Route::prefix('penerimaan_tanpa_po')->group(function(){
        Route::post('insert',[penerimaanTanpaPOController::class,'insert']);
        Route::post('get_by_param',[penerimaanTanpaPOController::class,'get_by_param']);
        Route::get('get_by_id/{id_penerimaan}',[penerimaanTanpaPOController::class,'get_by_id']);
        Route::post('validasi',[penerimaanTanpaPOController::class,'validasi']);
    });