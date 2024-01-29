<?php

use App\Http\Controllers\Inventory\mutasiController;
use App\Http\Controllers\Inventory\mutasiLokasiController;
use App\Http\Controllers\Inventory\pemusnahanController;
use App\Http\Controllers\Inventory\produksiController;
use App\Http\Controllers\Inventory\repackingController;
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
use App\Http\Controllers\Master\settingHargaController;
use App\Http\Controllers\Master\supplierController;
use App\Http\Controllers\Pembelian\pemesananController;
use App\Http\Controllers\Pembelian\penerimaanDenganPOController;
use App\Http\Controllers\Pembelian\penerimaanKonsinyasiController;
use App\Http\Controllers\Pembelian\penerimaanTanpaPOController;
use App\Http\Controllers\Pembelian\returKonsinyasiController;
use App\Http\Controllers\Pembelian\returPembelianController;
use App\Http\Controllers\Penjualan\bankController;
use App\Http\Controllers\Penjualan\edcController;
use App\Http\Controllers\Penjualan\modalKasirController;
use App\Http\Controllers\Penjualan\msPromoDiskonController;
use App\Http\Controllers\Penjualan\msPromoHadianController;
use App\Http\Controllers\Penjualan\penjualanController;
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

Route::get('health',function(){
    return response()->json(['success'=>true,'data'=>'health']);
});

Route::post('register',[userController::class,'register']);
Route::post('login',[userController::class,'login']);

Route::group(['middleware' => ModifRequest::class], function () {
    Route::pointResource('user_group', userGroupController::class);
    Route::pointResource('member',memberController::class);
    Route::post('member/by_param',[memberController::class,'member_by_param']);
    Route::pointResource('divisi',divisiController::class);
    Route::pointResource('merk',merkController::class);
    Route::pointResource('satuan',satuanController::class);
    Route::pointResource('rak',rakController::class);
    Route::pointResource('warehouse',warehouseController::class);
    Route::pointResource('barang',barangController::class);
    Route::post('barang/by_param',[barangController::class,'barang_by_param']);
    Route::pointResource('barang_rak',barangRakController::class);
    Route::get('barang_rak/by_id_barang/{id_barang}',[barangRakController::class,'by_id_barang']);
    Route::get('barang_rak/by_id_rak/{id_rak}',[barangRakController::class,'by_id_rak']);
    Route::pointResource('barang_satuan',barangSatuanController::class);
    Route::get('barang_satuan/by_id_barang/{id_barang}',[barangSatuanController::class,'by_id_barang']);
    Route::pointResource('barang_komponen',barangKomponenController::class);
    Route::get('barang_komponen/by_id_barang/{id_barang}',[barangKomponenController::class,'by_id_barang']);
    Route::pointResource('barang_urai',barangUraiController::class);
    Route::get('barang_urai/by_id_barang/{id_barang}',[barangUraiController::class,'by_id_barang']);
    Route::pointResource('supplier',supplierController::class);
    Route::post('supplier/by_param',[supplierController::class,'supplier_by_param']);
    Route::pointResource('group',groupController::class);
    Route::pointResource('lokasi',lokasiController::class);
    Route::post('setting_harga',[settingHargaController::class,'insert']);
    Route::post('setting_harga/by_param',[settingHargaController::class,'by_param']);
    Route::get('setting_harga/{id_setting_harga}',[settingHargaController::class,'by_id']);
    
    Route::prefix('pembelian')->group(function(){
        Route::post('insert',[pemesananController::class,'insert']);
        Route::get('get_by_id/{id_pemesanan}',[pemesananController::class,'get_by_id']);
        Route::post('get_by_param',[pemesananController::class,'get_by_param']);
        Route::post('lookup_barang',[pemesananController::class,'lookup_barang']);
        Route::post('lookup_supplier',[pemesananController::class,'lookup_supplier']);
    });
    
    Route::prefix('penerimaan_dengan_po')->group(function(){
        Route::post('lookup_pemesanan',[penerimaanDenganPOController::class,'lookup_pemesanan']);
        Route::post('lookup_barang/{id_pemesanan}',[penerimaanDenganPOController::class,'lookup_barang']);
        Route::post('insert',[penerimaanDenganPOController::class,'insert']);
        Route::post('get_by_param',[penerimaanDenganPOController::class,'get_by_param']);
        Route::get('get_by_id/{id_penerimaan}',[penerimaanDenganPOController::class,'get_by_id']);
        Route::post('validasi',[penerimaanDenganPOController::class,'validasi']);
    });
    
    Route::prefix('penerimaan_tanpa_po')->group(function(){
        Route::post('insert',[penerimaanTanpaPOController::class,'insert']);
        Route::post('get_by_param',[penerimaanTanpaPOController::class,'get_by_param']);
        Route::get('get_by_id/{id_penerimaan}',[penerimaanTanpaPOController::class,'get_by_id']);
        Route::post('validasi',[penerimaanTanpaPOController::class,'validasi']);
    });
    
    Route::prefix('penerimaan_konsinyasi')->group(function(){
        Route::post('insert',[penerimaanKonsinyasiController::class,'insert']);
        Route::post('get_by_param',[penerimaanKonsinyasiController::class,'get_by_param']);
        Route::get('get_by_id/{id_penerimaan}',[penerimaanKonsinyasiController::class,'get_by_id']);
        Route::post('validasi',[penerimaanKonsinyasiController::class,'validasi']);
    });
    
    Route::prefix('retur_pembelian')->group(function(){
        Route::post('insert',[returPembelianController::class,'insert']);
        Route::post('get_by_param',[returPembelianController::class,'get_by_param']);
        Route::get('get_by_id/{id_retur_pembelian}',[returPembelianController::class,'get_by_id']);
        Route::post('validasi',[returPembelianController::class,'validasi']);
    });
    
    Route::prefix('retur_konsinyasi')->group(function(){
        Route::post('insert',[returKonsinyasiController::class,'insert']);
        Route::post('get_by_param',[returKonsinyasiController::class,'get_by_param']);
        Route::get('get_by_id/{id_retur_pembelian}',[returKonsinyasiController::class,'get_by_id']);
        Route::post('validasi',[returKonsinyasiController::class,'validasi']);
    });

    Route::prefix('mutasi_warehouse')->group(function(){
        Route::post('lookup_barang/{id_warehouse}',[mutasiController::class,'lookup_barang']);
        Route::post('insert',[mutasiController::class,'insert']);
        Route::get('get_by_id/{id_mutasi_warehouse}',[mutasiController::class,'get_by_id']);
        Route::post('get_by_param',[mutasiController::class,'get_by_param']);
        Route::post('validasi',[mutasiController::class,'validasi']);
    });
    
    Route::prefix('mutasi_lokasi')->group(function(){
        Route::post('lookup_barang/{id_warehouse}',[mutasiLokasiController::class,'lookup_barang']);
        Route::get('lookup_lokasi',[mutasiLokasiController::class,'lookup_lokasi']);
        Route::post('insert',[mutasiLokasiController::class,'insert']);
        Route::get('get_by_id/{id_mutasi_lokasi}',[mutasiLokasiController::class,'get_by_id']);
        Route::post('get_by_param',[mutasiLokasiController::class,'get_by_param']);
        // Route::post('validasi',[mutasiLokasiController::class,'validasi']);
    });
    
    Route::prefix('produksi')->group(function(){
        Route::get('lookup_barang/{id_barang}',[produksiController::class,'lookup_barang']);
        Route::post('insert',[produksiController::class,'insert']);
        Route::get('get_by_id/{id_produksi}',[produksiController::class,'get_by_id']);
        Route::post('get_by_param',[produksiController::class,'get_by_param']);
        Route::post('validasi',[produksiController::class,'validasi']);
    });
    
    Route::prefix('repacking')->group(function(){
        Route::get('lookup_barang/{id_barang}',[repackingController::class,'lookup_barang']);
        Route::post('insert',[repackingController::class,'insert']);
        Route::get('get_by_id/{id_repacking}',[repackingController::class,'get_by_id']);
        Route::post('get_by_param',[repackingController::class,'get_by_param']);
        Route::post('validasi',[repackingController::class,'validasi']);
    });
    
    Route::prefix('pemusnahan')->group(function(){
        Route::get('lookup_barang/{id_barang}',[pemusnahanController::class,'lookup_barang']);
        Route::post('insert',[pemusnahanController::class,'insert']);
        Route::get('get_by_id/{id_pemusnahan}',[pemusnahanController::class,'get_by_id']);
        Route::post('get_by_param',[pemusnahanController::class,'get_by_param']);
        Route::post('validasi',[pemusnahanController::class,'validasi']);
    });
    
    Route::pointResource('bank',bankController::class);
    Route::pointResource('edc',edcController::class);
    Route::pointResource('modal_kasir',modalKasirController::class);
    Route::pointResource('ms_promo_diskon',msPromoDiskonController::class);
    Route::pointResource('ms_promo_hadiah',msPromoHadianController::class);

    Route::prefix('penjualan')->group(function(){
        Route::post('insert',[penjualanController::class,'insert']);
        Route::post('get_by_param',[penjualanController::class,'get_by_param']);
        Route::get('get_by_id/{id_penjualan}',[penjualanController::class,'get_by_id']);
    });
    
});