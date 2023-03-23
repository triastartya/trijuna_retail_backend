<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangSatuanRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangSatuanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new barangSatuanRepository();

        parent::__construct($this->repository);
    }
    
    public function by_id_barang()
    {
        try{
            $data = $this->repository->by_id_barang();
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
