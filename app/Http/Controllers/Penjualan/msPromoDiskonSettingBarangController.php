<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoDiskonSettingBarangRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoDiskonSettingBarangController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoDiskonSettingBarangRepository();
        parent::__construct($this->repository);
    }
    
    public function by_id_promo_diskon(){
        try{
            $data = $this->repository->by_id_promo_diskon();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
