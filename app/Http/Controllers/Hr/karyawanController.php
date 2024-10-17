<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Repositories\Hr\karyawanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class karyawanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new karyawanRepository();
        parent::__construct($this->repository);
    }

    public function getall()
    {
        $data = DB::select("
            select k.id_karyawan,
            k.kode_karyawan,
            k.nama_karyawan,
            k.alamat,
            d.kode_departemen,
            d.nama_departemen
            from hr_karyawan k
            left join hr_departemen d on k.id_departemen = d.id_departemen;
        ",[]);
        return response()->json(['success'=>true,'data'=>$data]);
    }
}
