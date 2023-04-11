<?php
use App\Http\Controllers\Master\divisiController;
use Illuminate\Support\Facades\Route;

    Route::pointResource('divisi',divisiController::class);