<?php
use App\Http\Controllers\userGroupController;
use Illuminate\Support\Facades\Route;

Route::pointResource('user_group', userGroupController::class);