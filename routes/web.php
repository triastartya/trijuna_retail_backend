<?php

use App\Http\Controllers\Master\barangController;
use App\Http\Controllers\migrasiController;
use App\Models\Master\msBarang;
use App\Models\Master\msBarangStok;
use App\Models\Master\msDivisi;
use App\Models\Master\msGroup;
use App\Models\Master\msMember;
use App\Models\Master\msMerk;
use App\Models\Master\msRak;
use App\Models\Master\msSatuan;
use App\Models\Master\msSupplier;
use App\Models\Master\msWarehouse;
use App\Models\Penjualan\posBank;
use App\Models\Penjualan\posEdc;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',function(){
    
    return view('layout.layout');
});
//====
Route::get('/migrasi',function(){
    $data = msMerk::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.migrasi',['items'=>$data]);
});

Route::post('migrasi/merk',[migrasiController::class,'merk']);
Route::get('migrasi/merk/truncate',function(){
    DB::select('truncate ms_merk restart identity;');
    return true;
});
//=======
Route::get('/migrasi_bank',function(){
    $data = posBank::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.bank',['items'=>$data]);
});

Route::post('migrasi/bank',[migrasiController::class,'bank']);
Route::get('migrasi/bank/truncate',function(){
    DB::select('truncate pos_bank restart identity;');
    return true;
});
//=======
Route::get('/migrasi_divisi',function(){
    $data = msDivisi::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.divisi',['items'=>$data]);
});

Route::post('migrasi/divisi',[migrasiController::class,'divisi']);
Route::get('migrasi/divisi/truncate',function(){
    DB::select('truncate ms_divisi restart identity;');
    return true;
});
//=======
Route::get('/migrasi_group',function(){
    $data = msGroup::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.group',['items'=>$data]);
});

Route::post('migrasi/group',[migrasiController::class,'group']);
Route::get('migrasi/group/truncate',function(){
    DB::select('truncate ms_group restart identity;');
    return true;
});
//=======
Route::get('/migrasi_edc',function(){
    $data = posEdc::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.edc',['items'=>$data]);
});

Route::post('migrasi/edc',[migrasiController::class,'edc']);
Route::get('migrasi/edc/truncate',function(){
    DB::select('truncate pos_edc restart identity;');
    return true;
});
//=======
Route::get('/migrasi_rak',function(){
    $data = msRak::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.rak',['items'=>$data]);
});

Route::post('migrasi/rak',[migrasiController::class,'rak']);
Route::get('migrasi/rak/truncate',function(){
    DB::select('truncate ms_rak restart identity;');
    return true;
});
//=======
Route::get('/migrasi_satuan',function(){
    $data = msSatuan::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.satuan',['items'=>$data]);
});

Route::post('migrasi/satuan',[migrasiController::class,'satuan']);
Route::get('migrasi/satuan/truncate',function(){
    DB::select('truncate ms_satuan restart identity;');
    return true;
});
//=======
Route::get('/migrasi_supplier',function(){
    $data = msSupplier::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.supplier',['items'=>$data]);
});

Route::post('migrasi/supplier',[migrasiController::class,'supplier']);
Route::get('migrasi/supplier/truncate',function(){
    DB::select('truncate ms_supplier restart identity;');
    return true;
});
//=======
Route::get('/migrasi_customer',function(){
    $data = msMember::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.customer',['items'=>$data]);
});

Route::post('migrasi/customer',[migrasiController::class,'customer']);
Route::get('migrasi/customer/truncate',function(){
    DB::select('truncate ms_member restart identity;');
    return true;
});
//=======
Route::get('/migrasi_barang',function(){
    // ini_set('memory_limit','2000M');
    // $data = msBarang::get();
    // $data = $data->toArray();
    $data = [];
    return view('migrasi.barang',['items'=>$data]);
});

Route::post('migrasi/barang',[migrasiController::class,'barang']);
Route::get('migrasi/barang/truncate',function(){
    DB::select('truncate ms_barang restart identity;');
    DB::select('truncate tr_setting_harga restart identity;');
    DB::select('truncate tr_setting_harga_detail restart identity;');
    return true;
});

Route::get('/migrasi_warehouse',function(){
    $data = msWarehouse::get();
    $data = $data->toArray();
    $data = $data;
    return view('migrasi.warehouse',['items'=>$data]);
});

Route::post('migrasi/warehouse',[migrasiController::class,'warehouse']);
Route::get('migrasi/warehouse/truncate',function(){
    DB::select('truncate ms_warehouse restart identity;');
    return true;
});

//MasterBarangOnWarehouse
Route::get('/migrasi_barangstok',function(){
    $data = [];
    return view('migrasi.barangstok',['items'=>$data]);
});
Route::post('migrasi/barangstok',[migrasiController::class,'barangstok']);
Route::get('migrasi/barangstok/truncate',function(){
    DB::select('truncate ms_barang_stok restart identity;');
    DB::select('truncate ms_barang_kartu_stok restart identity;');
    return true;
});

Route::get('/migrasi_updatesatuan',function(){
    $data = [];
    return view('migrasi.updatesatuan',['items'=>$data]);
});
Route::get('migrasi/updatesatuan',[barangController::class,'satuan_proses']);


Route::post('login', function () {
    return response()->json(['status'=>false,'data'=>'anda belum login']);
});
