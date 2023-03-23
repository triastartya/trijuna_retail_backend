<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\supplierRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class supplierController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new supplierRepository();
        
        parent::__construct($this->repository);
    }
    
    public function supplier_by_param()
    {
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
