<?php
use App\Http\Controllers\Master\memberController;
use Illuminate\Support\Facades\Route;
    
    Route::pointResource('member',memberController::class);
    Route::post('member/by_param',[memberController::class,'member_by_param']);