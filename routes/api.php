<?php
use App\Http\Controllers\userController;
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
    require __DIR__.'/master/user_group.php';
    require __DIR__.'/master/member.php';
    require __DIR__.'/master/divisi.php';
    require __DIR__.'/master/merk.php';
    require __DIR__.'/master/satuan.php';
    require __DIR__.'/master/rak.php';
    require __DIR__.'/master/warehouse.php';
    require __DIR__.'/master/barang.php';
    require __DIR__.'/master/supplier.php';
    require __DIR__.'/master/group.php';
    require __DIR__.'/master/lokasi.php';
    require __DIR__.'/master/setting_harga.php';
});
require __DIR__.'/pembelian/pembelian.php';
require __DIR__.'/pembelian/penerimaan_dengan_po.php';
require __DIR__.'/pembelian/penerimaan_tanpa_po.php';
