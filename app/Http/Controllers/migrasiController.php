<?php

namespace App\Http\Controllers;

use App\Models\Master\msDivisi;
use App\Models\Master\msGroup;
use App\Models\Master\msMember;
use App\Models\Master\msMerk;
use App\Models\Master\msSatuan;
use App\Models\Master\msSupplier;
use App\Models\Penjualan\posBank;
use App\Models\Penjualan\posEdc;
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
}
