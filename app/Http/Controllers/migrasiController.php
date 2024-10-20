<?php

namespace App\Http\Controllers;

use App\Models\Master\msBarang;
use App\Models\Master\msBarangKartuStok;
use App\Models\Master\msBarangRak;
use App\Models\Master\msBarangStok;
use App\Models\Master\msDivisi;
use App\Models\Master\msGroup;
use App\Models\Master\msMember;
use App\Models\Master\msMerk;
use App\Models\Master\msSatuan;
use App\Models\Master\msSupplier;
use App\Models\Master\msWarehouse;
use App\Models\Master\trSettingHarga;
use App\Models\Master\trSettingHargaDetail;
use App\Models\Penjualan\posBank;
use App\Models\Penjualan\posEdc;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class migrasiController extends VierController
{
    public $repository;

    public function __construct()
    {
        
    }

    public function bank(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = posBank::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data bank sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_bank' => $item['IdBank'],
                    'kode_bank' =>$item['KodeBank'],
                    'nama_bank' =>$item['NamaBank'],
                    'biaya' =>$item['Biaya'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            posBank::insert($merk);
            DB::select("SELECT setval('pos_bank_id_bank_seq', (SELECT MAX(id_bank) FROM pos_bank))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function edc(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = posEdc::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data edc sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_edc' => $item['IdEdc'],
                    'kode_edc' =>$item['KodeEdc'],
                    'nama_edc' =>$item['NamaEdc'],
                    'keterangan' =>$item['Keterangan'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            posEdc::insert($merk);
            DB::select("SELECT setval('pos_edc_id_edc_seq', (SELECT MAX(id_edc) FROM pos_edc))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function merk(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msMerk::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data merek sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_merk' => $item['IdMerk'],
                    'merk' =>$item['Merk'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            msMerk::insert($merk);
            DB::select("SELECT setval('ms_merk_id_merk_seq', (SELECT MAX(id_merk) FROM ms_merk))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function divisi(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msDivisi::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data divisi sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_divisi' => $item['IdDivisi'],
                    'kode_divisi' => $item['KodeDivisi'],
                    'divisi' =>$item['Divisi'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            msDivisi::insert($merk);
            DB::select("SELECT setval('ms_divisi_id_divisi_seq', (SELECT MAX(id_divisi) FROM ms_divisi))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function warehouse(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msWarehouse::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data warehouse sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_warehouse' => $item['IdWarehouse'],
                    'warehouse' => $item['NamaWarehouse'],
                    'lokasi' => $item['KodeWarehouse'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            msWarehouse::insert($merk);
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function group(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msGroup::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data group sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_group' => $item['IdGrup'],
                    'kode_group' =>$item['KodeGrup'],
                    'group' =>$item['Grup'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            msGroup::insert($merk);
            DB::select("SELECT setval('ms_group_id_group_seq', (SELECT MAX(id_group) FROM ms_group))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function rak(){
        DB::beginTransaction();
        try {
            return response()->json(['success'=>false,'data'=>[],'message'=>'error']);
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msMerk::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data merek sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_merk' => $item['IdMerk'],
                    'merk' =>$item['Merk'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            msMerk::insert($merk);
            DB::select("SELECT setval('ms_merk_id_merk_seq', (SELECT MAX(id_merk) FROM ms_merk))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function satuan(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msSatuan::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data satuan sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'kode_satuan' =>$item['KodeSatuan'],
                    'nama_satuan' =>$item['Satuan'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
            }
            msSatuan::insert($merk);
            DB::select("SELECT setval('ms_satuan_id_satuan_seq', (SELECT MAX(id_satuan) FROM ms_satuan))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function customer(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            ini_set('max_execution_time', request()->maximum_execution_time);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msMember::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data customer sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk = [
                    'id_member' => $item['IdCustomer'],
                    'kode_member' =>$item['KodeCustomer'],
                    'nama_member' =>$item['NamaCustomer'],
                    'alamat' =>$item['AlamatCustomer'],
                    'kota' =>'',
                    'kecamatan' =>'',
                    'kelurahan' =>'',
                    'pekerjaan' =>'',
                    'jenis_kelamin' =>$item['JenisKelamin'],
                    'no_handphone' =>$item['TelpWA'],
                    'email' =>$item['Email'],
                    'password' =>'123',
                    'jenis_identitas' =>$item['JenisIdentitas'],
                    'nomor_identitas' =>$item['NoIdentitas'],
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1
                ];
                // dd($merk);
                msMember::create($merk);    
            }
            
            DB::select("SELECT setval('ms_member_id_member_seq', (SELECT MAX(id_member) FROM ms_member))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$merk]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function supplier(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            ini_set('max_execution_time', request()->maximum_execution_time);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $cek = msSupplier::first();
            if($cek){
                return response()->json(['success'=>false,'data'=>[],'message'=>'data supplier sudah ada silahkan di truncate terlebih dahulu']);
            }
            $merk=[];
            foreach($json as $item){
                $merk[] = [
                    'id_supplier' => $item['IdSupplier'],
                    'kode_supplier' =>$item['KodeSupplier'],
                    'nama_supplier' =>$item['NamaSupplier'],
                    'alamat' =>$item['Alamat'],
                    'kota' =>'',
                    'kecamatan' =>'',
                    'kelurahan' =>'',
                    'keterangan' =>$item['Keterangan'],
                    'is_pkp' =>$item['IsPKP'],
                    'is_tanpa_po' =>$item['IsTanpaPO'],
                    'bank_rekening' =>$item['BankRekeningSupplier'],
                    'nama_pemilik_rekening' =>$item['NamaPemilikRekeningSupplier'],
                    'nomor_rekening' =>$item['NomorRekeningSupplier'],
                    'limit_hutang' =>100000000,
                    'no_handphone' =>'',
                    'email' =>'',
                    'sisa_hutang' =>0,
                    'is_active' => true,
                    'created_by' =>1,
                    'updated_by' =>1,
                    'npwp'=>$item['Npwp']
                ];
            }
            msSupplier::insert($merk);
            DB::select("SELECT setval('ms_supplier_id_supplier_seq', (SELECT MAX(id_supplier) FROM ms_supplier))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function barang(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            ini_set('max_execution_time', 0);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            $data_barang = [];
            $data_setting_harga = [];
            $setting= trSettingHarga::create([
                 'id_lokasi' => 1,
                 'tanggal_mulai_berlaku' => new DateTime()
            ]);
            foreach($json as $item){
                $item = (array)$item;
                $data_barang = [
                    'id_barang'=>$item['IdBarang'],
                    'id_divisi'=>$item['IdDivisi'],
                    'id_group'=>$item['IdGrup'],
                    'kode_barang'=>$item['KodeBarang'],
                    'barcode'=>$item['Barcode'],
                    'nama_barang'=>$item['NamaBarang'],
                    'kode_satuan'=>$item['KodeSatuanKecil'],
                    'kode_satuan2'=>$item['KodeSatuanMenengah'],
                    'isi_satuan2' =>$item['IsiSatuanMenengah'],
                    'kode_satuan3'=>$item['KodeSatuanBesar'],
                    'isi_satuan3' =>$item['IsiSatuanBesar'],
                    'id_merk'=>$item['IdMerk'],
                    'ukuran'=>$item['Ukuran'],
                    'warna'=>$item['Warna'],
                    'berat'=>0,
                    'id_supplier'=>$item['IdSupplier'],
                    'harga_order'=>$item['HargaOrder'],
                    'harga_beli_terakhir'=>$item['HargaBeliTerakhir'],
                    'hpp_average'=>$item['HppAverage'],
                    'is_ppn'=>$item['IsPPn'],
                    'nama_label'=>$item['NamaBarangDiLabel'],
                    'margin'=>$item['MarginHarga'],
                    'harga_jual' => $item['HargaJual'],
                    'qty_grosir1'=> ($item['JumlahGrosir1']==null)?0:$item['JumlahGrosir1'],
                    'harga_grosir1'=> ($item['HargaGrosir1']==null)?0:$item['HargaGrosir1'],
                    'qty_grosir2'=> ($item['JumlahGrosir2']==null)?0:$item['JumlahGrosir2'],
                    'harga_grosir2'=> ($item['HargaGrosir2']==null)?0:$item['HargaGrosir2'],
                    'created_by'=>1,
                    'updated_by'=>1
                ];
                // dd($data_barang);
                msBarang::create($data_barang);

                if($item['HargaJual'] != null OR $item['HargaJual'] !=0){
                    $data_setting_harga =[
                        'id_setting_harga' => $setting->id_setting_harga,
                        'tanggal_mulai_berlaku' =>$setting->tanggal_mulai_berlaku,
                        'id_barang' => $item['IdBarang'],
                        'harga_jual' => $item['HargaJual'],
                        'qty_grosir1'=> ($item['JumlahGrosir1']==null)?0:$item['JumlahGrosir1'],
                        'harga_grosir1'=> ($item['HargaGrosir1']==null)?0:$item['HargaGrosir1'],
                        'qty_grosir2'=> ($item['JumlahGrosir2']==null)?0:$item['JumlahGrosir2'],
                        'harga_grosir2'=> ($item['HargaGrosir2']==null)?0:$item['HargaGrosir2'],
                    ];
                    trSettingHargaDetail::create($data_setting_harga);
                }
            }
            // msBarang::insert($data_barang);
            // trSettingHargaDetail::insert($data_setting_harga);
            DB::select("SELECT setval('ms_barang_id_barang_seq', (SELECT MAX(id_barang) FROM ms_barang))");
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function barangstok(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit',request()->memory);
            ini_set('max_execution_time', 0);
            $file = request()->file;
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            // $cek = msBarangStok::first();
            // if($cek){
            //     return response()->json(['success'=>false,'data'=>[],'message'=>'data stok sudah ada silahkan di truncate terlebih dahulu']);
            // }
            $merk=[];
            $kartu_stok=[];
            foreach($json as $item){
                $barang = msBarang::where('id_barang',$item['IdBarang'])->first();
                $hpp_average = ($barang)?$barang->hpp_average:0;
                $hpp_average = ($hpp_average)?$hpp_average:0;
                msBarangStok::create([
                    'id_warehouse' => $item['IdWarehouse'],
                    'id_barang' => $item['IdBarang'],
                    'qty' =>$item['QtyOnHand']
                ]);
                msBarangKartuStok::create([
                    'tanggal' => date('Y-m-d'),
                    'id_warehouse' => $item['IdWarehouse'],
                    'id_barang' => $item['IdBarang'],
                    'nomor_reff' =>'STOK AWAL',
                    'id_header_trans' =>1,
                    'id_detail_trans' =>1,
                    'stok_awal' => 0,
                    'nominal_awal' => $hpp_average * $item['QtyOnHand'],
                    'stok_masuk' => $item['QtyOnHand'] ,
                    'nominal_masuk' => 0,
                    'stok_keluar' => 0,
                    'nominal_keluar' => $hpp_average * $item['QtyOnHand'],
                    'stok_akhir' => $item['QtyOnHand'],
                    'nominal_akhir' => 0,
                    'keterangan' =>'STOK AWAL',
                ]);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$json]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
