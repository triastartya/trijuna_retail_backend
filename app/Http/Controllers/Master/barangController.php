<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangController extends VierController
{
    public function __construct()
    {
        $repository = new barangRepository();

        parent::__construct($repository);
    }
    
    public function barang_by_param(){
        try{
            $data = $this->repository->barang_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
