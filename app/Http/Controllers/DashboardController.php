<?php

namespace App\Http\Controllers;

use App\Models\Pembelian\trPemesanan;
use App\Models\Pembelian\trPenerimaan;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class DashboardController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function pembelian(){
        return response()->json(['success'=>true,'data'=>[
            'pemesanan' => trPemesanan::where('status_pemesanan','OPEN')->count(),
            'penerimaanTanpaOP' => trPenerimaan::where('jenis_penerimaan',2)->where('status_penerimaan','OPEN')->count(),
            'penerimaanPO' => trPenerimaan::where('jenis_penerimaan',1)->where('status_penerimaan','OPEN')->count()
        ]]);
    }
}
