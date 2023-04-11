<?php
use App\Http\Controllers\Master\settingHargaController;
use Illuminate\Support\Facades\Route;

    Route::post('setting_harga',[settingHargaController::class,'insert']);
    Route::post('setting_harga/by_param',[settingHargaController::class,'by_param']);
    Route::get('setting_harga/{id_setting_harga}',[settingHargaController::class,'by_id']);