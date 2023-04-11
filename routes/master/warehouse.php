<?php
use App\Http\Controllers\Master\warehouseController;
use Illuminate\Support\Facades\Route;

    Route::pointResource('warehouse',warehouseController::class);