<?php
use App\Http\Controllers\Master\merkController;
use Illuminate\Support\Facades\Route;

    Route::pointResource('merk',merkController::class);