<?php
use App\Http\Controllers\Master\supplierController;
use Illuminate\Support\Facades\Route;

    Route::pointResource('supplier',supplierController::class);
    Route::post('supplier/by_param',[supplierController::class,'supplier_by_param']);