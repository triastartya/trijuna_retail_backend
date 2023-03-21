<?php

use App\Http\Controllers\Master\barangController;
use App\Http\Controllers\Master\barangKomponenController;
use App\Http\Controllers\Master\barangRakController;
use App\Http\Controllers\Master\barangSatuanController;
use App\Http\Controllers\Master\barangUraiController;
use App\Http\Controllers\Master\divisiController;
use App\Http\Controllers\Master\merkController;
use App\Http\Controllers\Master\rakController;
use App\Http\Controllers\Master\satuanController;
use App\Http\Controllers\Master\warehouseController;
use App\Http\Controllers\Master\groupController;
use App\Http\Controllers\Master\lokasiController;
use App\Http\Controllers\Master\memberController;
use App\Http\Controllers\Master\supplierController;
use App\Http\Controllers\Pembelian\pemesananController;
use App\Http\Controllers\userController;
use App\Http\Controllers\userGroupController;
use App\Http\Middleware\ModifRequest;
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

Route::group(['middleware' => 'auth:sanctum'], function () {

});

Route::post('register',[userController::class,'register']);
Route::post('login',[userController::class,'login']);

Route::group(['middleware' => ModifRequest::class], function () {
    Route::pointResource('user_group', userGroupController::class);
    Route::pointResource('member',memberController::class);
    Route::pointResource('divisi',divisiController::class);
    Route::pointResource('merk',merkController::class);
    Route::pointResource('satuan',satuanController::class);
    Route::pointResource('rak',rakController::class);
    Route::pointResource('warehouse',warehouseController::class);
    Route::pointResource('barang',barangController::class);
    Route::pointResource('barang_rak',barangRakController::class);
    Route::pointResource('barang_satuan',barangSatuanController::class);
    Route::pointResource('barang_komponen',barangKomponenController::class);
    Route::pointResource('barang_urai',barangUraiController::class);
    Route::pointResource('supplier',supplierController::class);
    Route::pointResource('group',groupController::class);
    Route::pointResource('lokasi',lokasiController::class);
    Route::prefix('pembelian')->group(function(){
        Route::post('insert',[pemesananController::class,'insert']);
        Route::get('get_by_id/{id_pemesanan}',[pemesananController::class,'get_by_id']);
        Route::post('get_by_param',[pemesananController::class,'get_by_param']);
    });
});
