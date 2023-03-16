<?php

use App\Http\Controllers\Master\barangController;
use App\Http\Controllers\Master\divisiController;
use App\Http\Controllers\Master\memberController;
use App\Http\Controllers\Master\merkController;
use App\Http\Controllers\Master\rakController;
use App\Http\Controllers\Master\satuanController;
use App\Http\Controllers\Master\warehouseController;
use App\Http\Controllers\userController;
use App\Http\Controllers\userGroupController;
use App\Http\Middleware\ModifRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register',[userController::class,'register']);
Route::post('login',[userController::class,'login']);

Route::group(['middleware' => 'auth:sanctum','middleware' => ModifRequest::class], function () {
    Route::attResource('user_group', userGroupController::class);
    Route::attResource('member',memberController::class);
    Route::attResource('divisi',divisiController::class);
    Route::attResource('merk',merkController::class);
    Route::attResource('satuan',satuanController::class);
    Route::attResource('rak',rakController::class);
    Route::attResource('warehouse',warehouseController::class);
    Route::attResource('barang',barangController::class);
});