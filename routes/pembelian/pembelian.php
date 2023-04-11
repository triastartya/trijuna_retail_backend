<?php
use App\Http\Controllers\Pembelian\pemesananController;
use Illuminate\Support\Facades\Route;

Route::prefix('pembelian')->group(function(){
    Route::post('insert',[pemesananController::class,'insert']);
    Route::get('get_by_id/{id_pemesanan}',[pemesananController::class,'get_by_id']);
    Route::post('get_by_param',[pemesananController::class,'get_by_param']);
    Route::post('lookup_barang',[pemesananController::class,'lookup_barang']);
    Route::post('lookup_supplier',[pemesananController::class,'lookup_supplier']);
});