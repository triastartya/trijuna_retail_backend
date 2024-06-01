<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoBonusSettingBarangRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoBonusSettingBarangController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoBonusSettingBarangRepository();
        parent::__construct($this->repository);
    }
    public function by_id_promo_bonus(){
        try{
            $data = $this->repository->by_id_promo_bonus();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
