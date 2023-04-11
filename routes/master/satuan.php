<?php
use App\Http\Controllers\Master\satuanController;
use Illuminate\Support\Facades\Route;

    Route::pointResource('satuan',satuanController::class);