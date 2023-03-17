<?php

use App\Http\Controllers\Master\barangController;
use App\Http\Controllers\Master\barangKomponenController;
use App\Http\Controllers\Master\barangRakController;
use App\Http\Controllers\Master\barangSatuanController;
use App\Http\Controllers\Master\barangStokController;
use App\Http\Controllers\Master\barangUraiController;
use App\Http\Controllers\Master\divisiController;
use App\Http\Controllers\Master\memberController;
use App\Http\Controllers\Master\merkController;
use App\Http\Controllers\Master\rakController;
use App\Http\Controllers\Master\satuanController;
use App\Http\Controllers\Master\warehouseController;
use App\Http\Controllers\Master\groupController;
use App\Http\Controllers\Master\memberController;
use App\Http\Controllers\Master\supplierController;
use App\Http\Controllers\Pembelian\pemesananController;
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
    Route::attResource('barang_rak',barangRakController::class);
    Route::attResource('barang_satuan',barangSatuanController::class);
    Route::attResource('barang_komponen',barangKomponenController::class);
    Route::attResource('barang_urai',barangUraiController::class);
});
    Route::attResource('supplier',supplierController::class);
    Route::attResource('group',groupController::class);
    Route::prefix('pembelian')->group(function(){
        Route::post('insert',[pemesananController::class,'insert']);
    });
});
