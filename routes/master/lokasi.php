<?php
use App\Http\Controllers\Master\lokasiController;
use Illuminate\Support\Facades\Route;

    Route::pointResource('lokasi',lokasiController::class);