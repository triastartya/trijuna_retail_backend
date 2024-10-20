<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\bayarHutangController;
use App\Http\Controllers\Finance\bayarHutangPelunasanController;
use App\Http\Controllers\Finance\fakturPajakController;
use App\Http\Controllers\Inventory\mutasiController;
use App\Http\Controllers\Inventory\mutasiLokasiController;
use App\Http\Controllers\Inventory\pemusnahanController;
use App\Http\Controllers\Inventory\produksiController;
use App\Http\Controllers\Inventory\repackingController;
use App\Http\Controllers\Inventory\stokOpnameController;
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
use App\Http\Controllers\Penjualan\msPromoBonusController;
use App\Http\Controllers\Penjualan\msPromoBonusSettingBarangController;
use App\Http\Controllers\Penjualan\msPromoBonusSettingItemController;
use App\Http\Controllers\Penjualan\msPromoBonusSettingMerkController;
use App\Http\Controllers\Penjualan\msPromoBonusSettingSupplierController;
use App\Http\Controllers\Penjualan\msPromoDiskonController;
use App\Http\Controllers\Penjualan\msPromoDiskonSettingBarangController;
use App\Http\Controllers\Penjualan\msPromoDiskonSettingMerkController;
use App\Http\Controllers\Penjualan\msPromoDiskonSettingSupplierController;
use App\Http\Controllers\Penjualan\msPromoHadiahSettingBarangController;
use App\Http\Controllers\Penjualan\msPromoHadiahSettingMerkController;
use App\Http\Controllers\Penjualan\msPromoHadiahSettingSupplierController;
use App\Http\Controllers\Penjualan\msPromoHadianController;
use App\Http\Controllers\Penjualan\penjualanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\userController;
use App\Http\Controllers\userGroupController;
use App\Http\Middleware\ModifRequest;
use App\Models\Finance\trBayarHutang;
use App\Http\Controllers\Finance\kasirController;
use App\Http\Controllers\Finance\posKroscekTutupKasirController;
use App\Http\Controllers\Finance\posTutupKasirController;
use App\Http\Controllers\Finance\posPaymentMethodController;
use App\Http\Controllers\Hr\absenController;
use App\Http\Controllers\Hr\departemenController;
use App\Http\Controllers\Hr\karyawanController;
use App\Http\Controllers\Inventory\mutasiKeluarController;
use App\Http\Controllers\Inventory\mutasiMasukController;
use App\Http\Controllers\Inventory\trInputStokOpnameController;
use App\Http\Controllers\Inventory\trSettingStokOpnameController;
use App\Http\Controllers\Master\PotonganPembelianController;
use App\Http\Controllers\Master\rekeningOwnerController;
use App\Http\Controllers\migrasiController;
use App\Http\Controllers\Penjualan\refundController;
use App\Models\Inventory\trSettingStokOpname;
use App\Models\Master\msBarang;
use App\Models\Master\msRekeningOwner;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;

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



Route::get('add',[ReportController::class,'addtes']);
Route::get('get',[ReportController::class,'gettes']);

Route::get('health',function(){
    return response()->json(['success'=>true,'data'=>'health']);
});

Route::post('register',[userController::class,'register']);
Route::post('login',[userController::class,'login']);
Route::post('login/kasir',[userController::class,'login_kasir']);
Route::get('list/kasir',[userController::class,'getkasir']);

Route::get('user_list',[userController::class,'list']);
Route::get('barang_satuan/proses',[barangController::class,'satuan_proses']);
Route::put('user_update/{id_user}',[userController::class,'edit']);
Route::get('barang/lihat_omzet/{id_barang}',[barangController::class,'lihat_omzet']);
Route::post('barang/kartu_stok',[barangController::class,'kartu_stok']);
Route::get('barang/lihat_stok/{id_barang}',[barangController::class,'lihat_stok']);
Route::get('barang/lihat_stok_omzet/{id_barang}',[barangController::class,'lihat_stok_omzet']);
Route::get('barang/lihat_stok_omzet_cabang/{id_barang}',[barangController::class,'lihat_stok_omzet_cabang']);
Route::get('barang/lihat_stok_cabang/{id_barang}',[barangController::class,'lihat_stok_cabang']);
Route::get('dashboard',[DashboardController::class,'pembelian']);

Route::post('mutasi_lokasi_masuk/insertbyapi',[mutasiMasukController::class,'insertbyapi']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['middleware' => ModifRequest::class], function () {
        Route::get('hr_karyawan',[karyawanController::class,'getall']);
        Route::post('hr_karyawan',[karyawanController::class,'store']);
        Route::put('hr_karyawan/{id}',[karyawanController::class,'update']);
        Route::delete('hr_karyawan/{id}',[karyawanController::class,'destroy']);
        Route::get('absen/{start}/{end}',[absenController::class,'byparam']);
        Route::post('absen',[absenController::class,'absen']);
        Route::post('raw/tes',[divisiController::class,'testing']);
        Route::get('hr_departemen',[departemenController::class,'getall']);
        Route::post('hr_departemen',[departemenController::class,'store']);
        Route::put('hr_departemen/{id}',[departemenController::class,'update']);
        Route::delete('hr_departemen/{id}',[departemenController::class,'destroy']);
        Route::pointResource('user_group', userGroupController::class);
        Route::pointResource('member',memberController::class);
        Route::post('member/by_param',[memberController::class,'member_by_param']);
        Route::pointResource('divisi',divisiController::class);
        Route::get('divisi/data/import',[divisiController::class,'import_divisi']);
        Route::pointResource('group',groupController::class);
        Route::get('group/data/import',[groupController::class,'import']);
        Route::pointResource('merk',merkController::class);
        Route::get('merk/data/import',[merkController::class,'import']);
        Route::pointResource('satuan',satuanController::class);
        Route::get('satuan/data/import',[satuanController::class,'import']);
        Route::pointResource('lokasi',lokasiController::class);
        Route::pointResource('merk',merkController::class);
        Route::pointResource('rak',rakController::class);
        Route::pointResource('warehouse',warehouseController::class);
        Route::pointResource('barang',barangController::class);

        Route::post('tambahbarang',[barangController::class,'tambah']);
        Route::put('updatebarang/{id_barang}',[barangController::class,'edit']);
        Route::get('barang/update_status_active/{id_barang}',[barangController::class,'update_status_active']);
        Route::get('getbarangpos',[barangController::class,'barang_pos']);
        Route::get('barang/data/import',[barangController::class,'import']);
        Route::post('barang/by_param',[barangController::class,'barang_by_param']);
        Route::post('barang_no_limit/by_param',[barangController::class,'barang_no_limit_by_param']);
        Route::get('barang/by_id/{id_barang}',[barangController::class,'by_id']);
        Route::get('barang/history_penerimaan/{id_barang}',[barangController::class,'history_penerimaan']);
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
        Route::get('supplier/data/import',[supplierController::class,'import']);
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

        Route::prefix('faktur_pajak')->group(function(){
            Route::post('get_penerimaan_belum_faktur_pajak_by_pharam',[fakturPajakController::class,'get_penerimaan_belum_faktur_pajak_by_param']);
            Route::post('insert',[fakturPajakController::class,'insert']);
            Route::post('get_by_param',[fakturPajakController::class,'get_by_param']);
            Route::get('get_by_id/{id_faktur_pajak}',[fakturPajakController::class,'get_by_id']);
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
        Route::get('bank/data/import',[bankController::class,'import']);
        Route::pointResource('edc',edcController::class);
        Route::get('edc/data/import',[edcController::class,'import']);
        Route::pointResource('modal_kasir',modalKasirController::class);
        Route::get('modal_kasir_get',[modalKasirController::class,'getall']);
        
        Route::pointResource('ms_promo_diskon',msPromoDiskonController::class);
        Route::get('ms_promo_diskon_detail/{id_promo_diskon}',[msPromoDiskonController::class,'get_detail']);

        Route::pointResource('ms_promo_diskon_setting_barang',msPromoDiskonSettingBarangController::class);
        Route::get('ms_promo_diskon_setting_barang_by_id_promo_diskon/{id_promo_diskon}',[msPromoDiskonSettingBarangController::class,'by_id_promo_diskon']);
        Route::pointResource('ms_promo_diskon_setting_merk',msPromoDiskonSettingMerkController::class);
        Route::get('ms_promo_diskon_setting_merk_by_id_promo_diskon/{id_promo_diskon}',[msPromoDiskonSettingMerkController::class,'by_id_promo_diskon']);
        Route::pointResource('ms_promo_diskon_setting_supplier',msPromoDiskonSettingSupplierController::class);
        Route::get('ms_promo_diskon_setting_supplier_by_id_promo_diskon/{id_promo_diskon}',[msPromoDiskonSettingSupplierController::class,'by_id_promo_diskon']);
        
        Route::pointResource('ms_promo_hadiah',msPromoHadianController::class);
        Route::get('ms_promo_hadiah_detail/{id_promo_hadiah}',[msPromoHadianController::class,'get_detail']);
        
        Route::pointResource('ms_promo_hadiah_setting_barang',msPromoHadiahSettingBarangController::class);
        Route::get('ms_promo_hadiah_setting_barang_by_id_promo_hadiah/{id_promo_hadiah}',[msPromoHadiahSettingBarangController::class,'by_id_promo_hadiah']);
        Route::pointResource('ms_promo_hadiah_setting_merk',msPromoHadiahSettingMerkController::class);
        Route::get('ms_promo_diskon_setting_merk_by_id_promo_hadiah/{id_promo_hadiah}',[msPromoHadiahSettingMerkController::class,'by_id_promo_hadiah']);
        Route::pointResource('ms_promo_hadiah_setting_supplier',msPromoHadiahSettingSupplierController::class);
        Route::get('ms_promo_diskon_setting_supplier_by_id_promo_hadiah/{id_promo_hadiah}',[msPromoHadiahSettingSupplierController::class,'by_id_promo_hadiah']);
        
        Route::pointResource('ms_promo_bonus',msPromoBonusController::class);
        Route::get('ms_promo_bonus_detail/{id_promo_bonus}',[msPromoBonusController::class,'get_detail']);
        Route::pointResource('ms_promo_bonus_setting_barang',msPromoBonusSettingBarangController::class);
        Route::get('ms_promo_bonus_barang_by_id_promo_bonus/{id_promo_bonus}',[msPromoBonusSettingBarangController::class,'by_id_promo_bonus']);
        // Route::pointResource('ms_promo_bonus_setting_item',msPromoBonusSettingItemController::class);
        // Route::pointResource('ms_promo_bonus_setting_merk',msPromoBonusSettingMerkController::class);
        // Route::pointResource('ms_promo_bonus_setting_supplier',msPromoBonusSettingSupplierController::class);
        Route::prefix('stok_opname')->group(function(){
            Route::post('insert',[stokOpnameController::class,'insert']);
            Route::post('insert_detail',[stokOpnameController::class,'insert_detail']);
            Route::post('get_by_param',[stokOpnameController::class,'get_by_param']);
            Route::get('get_by_id/{id_audit_stok_opname}',[stokOpnameController::class,'get_by_id']);
            Route::post('lookup_barang',[stokOpnameController::class,'lookup_barang']);
        });

        Route::pointResource('ms_potongan_pembelian',PotonganPembelianController::class);

        Route::prefix('bayar_hutang_supplier')->group(function(){
            Route::get('get_belum_lunas_by_id_supplier/{id_supplier}',[bayarHutangController::class,'get_data_belum_lunas']);
            Route::post('insert',[bayarHutangController::class,'insert']);
            Route::post('get_by_param',[bayarHutangController::class,'get_by_param']);
            Route::get('get_by_id/{id_bayar_hutang}',[bayarHutangController::class,'get_by_id']);
            Route::post('lookup_supplier_by_param',[bayarHutangController::class,'lookup_supplier']);
            Route::post('lookup_penerimaan_belum_lunas_by_param',[bayarHutangController::class,'lookup_penerimaan_belum_lunas']);
            Route::post('lookup_retur_potong_tagihan_by_param',[bayarHutangController::class,'lookup_retur_potong_tagihan']);
        });

        Route::pointResource('ms_rekening_owner',rekeningOwnerController::class);
        
        Route::prefix('pelunasan_titip_tagihan')->group(function(){
            Route::post('get_tt_belum_terbayar',[bayarHutangController::class,'tt_belum_terbayar']);
            Route::post('insert',[bayarHutangPelunasanController::class,'insert']);
            Route::post('get_by_param',[bayarHutangPelunasanController::class,'get_by_param']);
            Route::get('get_by_id/{id_bayar_hutang_pelunasan}',[bayarHutangPelunasanController::class,'get_by_id']);
        });

        Route::prefix('bayar_piutang_member')->group(function(){
            
        });

        Route::prefix('penjualan')->group(function(){
            Route::get('minimal',[penjualanController::class,'minimal']);
            Route::post('insert',[penjualanController::class,'insert']);
            Route::post('get_by_param',[penjualanController::class,'get_by_param']);
            Route::get('get_by_id/{id_penjualan}',[penjualanController::class,'get_by_id']);
            Route::get('get_by_no_nota/{nota_penjualan}',[penjualanController::class,'get_by_no_nota']);
            Route::post('sell_out_item',[penjualanController::class,'sell_out_item']);
        });

        Route::prefix('refund')->group(function(){
            Route::post('insert',[refundController::class,'insert']);
            Route::post('get_by_param',[refundController::class,'get_by_param']);
            Route::get('get_by_id/{id_refund}',[refundController::class,'get_by_id']);
        });

        Route::prefix('kasir')->group(function(){
            Route::get('get_modal_kasir/{id_user_kasir}',[kasirController::class,'get_modal_kasir']);
            Route::post('tutup_kasir',[posTutupKasirController::class,'tutup_kasir']);
            Route::get('kasir_belum_tutup_kasir',[posTutupKasirController::class,'kasir_belum_closing']);
            Route::post('history_tutup_kasir',[posTutupKasirController::class,'history']);
            Route::get('detail_tutup_kasir/{id_tutup_kasir}',[posTutupKasirController::class,'detail_tutup_kasir']);
        });

        Route::prefix('kroscek_tutup_kasir')->group(function(){
            Route::get('tutup_kasir_belum_croscek',[posKroscekTutupKasirController::class,'tutup_kasir_belum_croscek']);
            Route::get('detail_tutup_kasir/{id_tutup_kasir}',[posTutupKasirController::class,'detail_tutup_kasir']);
            Route::post('by_param',[posKroscekTutupKasirController::class,'by_param']);
            Route::get('by_id/{id_kroscek_tutup_kasir}',[posKroscekTutupKasirController::class,'by_id']);
            Route::post('validasi',[posKroscekTutupKasirController::class,'kroscek_tutup_kasir']);
        });

        Route::prefix('mutasi_lokasi_masuk')->group(function(){
            // Route::post('insert',[mutasiMasukController::class,'insert']);
            Route::post('upload',[mutasiMasukController::class,'insert']);
            Route::post('by_param',[mutasiMasukController::class,'by_param']);
            Route::get('by_id/{id_mutasi_lokasi}',[mutasiMasukController::class,'by_id']);
            Route::post('validasi',[mutasiMasukController::class,'validasi']);
        });

        Route::prefix('mutasi_lokasi_keluar')->group(function(){
            Route::post('insert',[mutasiKeluarController::class,'insert']);
            Route::post('by_param',[mutasiKeluarController::class,'by_param']);
            Route::get('by_id/{id_mutasi_lokasi}',[mutasiLokasiController::class,'get_by_id']);
            Route::post('validasi',[mutasiKeluarController::class,'validasi']);
            Route::post('validasi_online',[mutasiKeluarController::class,'validasi_online']);
            // Route::get('download/{id_mutasi_lokasi}',[mutasiKeluarController::class,'download']);
        });

        Route::prefix('setting_stok_opname')->group(function(){
            Route::post('insert',[trSettingStokOpnameController::class,'insert']);
            Route::post('get_by_param',[trSettingStokOpnameController::class,'by_param']);
            Route::get('get_by_id/{id_setting_stok_opname}',[trSettingStokOpnameController::class,'by_id']);
            Route::get('kalkulasi/{id_setting_stok_opname}',[trSettingStokOpnameController::class,'kalkulasi']);
            Route::post('finalisasi',[trSettingStokOpnameController::class,'finalisasi']);
        });

        Route::prefix('input_stok_opname')->group(function(){
            Route::post('insert',[trInputStokOpnameController::class,'insert']);
            Route::post('get_setting_OS_by_param',[trInputStokOpnameController::class,'get_setting_open']);
            Route::get('get_barang_by_setting_so/{id_setting_stok_opname}',[trInputStokOpnameController::class,'get_barang_by_setting_so']);
            Route::post('get_by_param',[trInputStokOpnameController::class,'by_param']);
            Route::get('get_by_id/{id_input_stok_opname}',[trInputStokOpnameController::class,'by_id']);
        });

        Route::pointResource('paymentMethod', posPaymentMethodController::class);
    });
});

Route::prefix('mutasi_lokasi_keluar')->group(function(){
    Route::get('download/{id_mutasi_lokasi}',[mutasiKeluarController::class,'download']);
});