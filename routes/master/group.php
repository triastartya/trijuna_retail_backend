<?php
use App\Http\Controllers\Master\groupController;
use Illuminate\Support\Facades\Route;
    
    Route::pointResource('group',groupController::class);