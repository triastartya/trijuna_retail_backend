<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoHadiahSettingBarangRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoHadiahSettingBarangController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoHadiahSettingBarangRepository();
        parent::__construct($this->repository);
    }
    
    public function by_id_promo_hadiah(){
        try{
            $data = $this->repository->by_id_promo_hadiah();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}