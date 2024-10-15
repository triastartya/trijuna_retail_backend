<?php

namespace App\Http\Controllers\Hr;

use App\Helpers\QueryHelper;
use App\Http\Controllers\Controller;
use App\Models\Hr\hrAbsen;
use App\Models\Hr\hrKaryawan;
use App\Repositories\Hr\absenRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class absenController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new absenRepository();
        parent::__construct($this->repository);
    }

    public function byparam(){
        $data = DB::select("
            select hk.nama_karyawan,ha.*
            from hr_absen ha inner join hr_karyawan hk on ha.id_karyawan=hk.id_karyawan
            where ha.tanggal between ? and ?;
        ",[request()->start,request()->end]);
        return response()->json(['success'=>true,'data'=>['data'=>$data]]);
    } 

    public function absen(){
        try{
            $karyawan = hrKaryawan::where('kode_karyawan',request()->kode_karyawan)->first();
            if(!$karyawan){
                return response()->json(['success'=>false,'data'=>[],'message'=>'tidak di temukan karyawan dengan kode '.request()->kode_karyawan]);
            }
            $tgl =date('Y-m-d');
            $absen = hrAbsen::where('id_karyawan',$karyawan->id_karyawan)->where('tanggal',$tgl)->first();
            if(!$absen){
                $absen_baru = hrAbsen::create([
                    'id_karyawan'=>$karyawan->id_karyawan,
                    'masuk1' => date("Y-m-d H:i:s"),
                    'tanggal' => date("Y-m-d")
                ]);
            }else{
                if($absen->keluar1==null){
                    $absen->keluar1 = date("Y-m-d H:i:s");
                }else{
                    if($absen->masuk2==null){
                        $absen->masuk2 = date("Y-m-d H:i:s");
                    }else{
                        $absen->keluar2 = date("Y-m-d H:i:s");
                    }
                }
                $absen->save();
            }
            return response()->json(['success'=>true,'data'=>$karyawan]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
}
