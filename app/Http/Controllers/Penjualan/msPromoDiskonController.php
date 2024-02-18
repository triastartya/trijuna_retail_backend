<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoDiskonRepository;
use App\Repositories\Penjualan\msPromoDiskonSettingBarangRepository;
use App\Repositories\Penjualan\msPromoDiskonSettingMerkRepository;
use App\Repositories\Penjualan\msPromoDiskonSettingSupplierRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoDiskonController extends VierController
{
    public $repository;
    public $repository_diskon_barang;
    public $repository_diskon_merk;
    public $repository_diskon_supplier;
    public function __construct()
    {
        $this->repository = new msPromoDiskonRepository();
        $this->repository_diskon_barang = new msPromoDiskonSettingBarangRepository();
        $this->repository_diskon_merk = new msPromoDiskonSettingMerkRepository();
        $this->repository_diskon_supplier = new msPromoDiskonSettingSupplierRepository();
        parent::__construct($this->repository);
    }
    
    public function get_detail()
    {
        try{
            $data = $this->repository->find(request()->id_promo_diskon);
            $data->barang = $this->repository_diskon_barang->by_id_promo_diskon();
            $data->merk = $this->repository_diskon_merk->by_id_promo_diskon();
            $data->supplier = $this->repository_diskon_supplier->by_id_promo_diskon();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
