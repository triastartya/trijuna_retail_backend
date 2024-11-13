<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\msPromoHadiah;
use App\Repositories\Penjualan\msPromoHadiahRepository;
use App\Repositories\Penjualan\msPromoHadiahSettingBarangRepository;
use App\Repositories\Penjualan\msPromoHadiahSettingMerkRepository;
use App\Repositories\Penjualan\msPromoHadiahSettingSupplierRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoHadianController extends VierController
{
    public $repository;
    public $repository_hadiah_barang;
    public $repository_hadiah_merk;
    public $repository_hadiah_supplier;
    public function __construct()
    {
        $this->repository = new msPromoHadiahRepository();
        $this->repository_hadiah_barang = new msPromoHadiahSettingBarangRepository();
        $this->repository_hadiah_merk = new msPromoHadiahSettingMerkRepository();
        $this->repository_hadiah_supplier = new msPromoHadiahSettingSupplierRepository();
        parent::__construct($this->repository);
    }
    
    public function get_detail()
    {
        try{
            $data = $this->repository->find(request()->id_promo_hadiah);
            $data->barang = $this->repository_hadiah_barang->by_id_promo_hadiah();
            $data->merk = $this->repository_hadiah_merk->by_id_promo_hadiah();
            $data->supplier = $this->repository_hadiah_supplier->by_id_promo_hadiah();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function pos_promo_hadiah(){
        try{
            $now = date("Y-m-d");
            $data = msPromoHadiah::with('barang')->where('tanggal_mulai','<=',$now)
            ->where('tanggal_berakhir','>=',$now)->where('is_active',true)->get();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
