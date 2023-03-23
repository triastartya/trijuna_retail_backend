<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangKomponenRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangKomponenController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new barangKomponenRepository();

        parent::__construct($this->repository);
    }
    
    public function by_id_barang(){
        try{
            $data = $this->repository->by_id_barang();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
