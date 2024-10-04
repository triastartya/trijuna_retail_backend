<?php

namespace App\Http\Controllers;

use App\Models\Master\msMerk;
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

    public function edc(){
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

    public function group(){
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

    public function rak(){
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

    public function satuan(){
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

    public function customer(){
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

    public function supplier(){
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
