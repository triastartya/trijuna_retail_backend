<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\modalKasirRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class modalKasirController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new modalKasirRepository();
        parent::__construct($this->repository);
    }

    public function getall()
    {
        try{
            $data = DB::select("
                select pmk.id_modal_kasir, pmk.id_user_kasir,u.nama as nama_kasir, pmk.tanggal_modal_kasir, pmk.modal_kasir, pmk.is_deleted, pmk.deleted_by, pmk.deleted_at, pmk.deleted_reason, pmk.created_by, pmk.updated_by, pmk.id_tutup_kasir, pmk.created_at, pmk.updated_at
                from pos_modal_kasir pmk inner join users u on pmk.id_user_kasir=u.id_user;
            ",[]);
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}