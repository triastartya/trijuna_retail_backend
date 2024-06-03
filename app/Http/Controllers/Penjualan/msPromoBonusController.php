<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\msPromoBonusSettingBarang;
use App\Models\Penjualan\msPromoBonusSettingSupplier;
use App\Repositories\Penjualan\msPromoBonusRepository;
use App\Repositories\Penjualan\msPromoBonusSettingBarangRepository;
use App\Repositories\Penjualan\msPromoBonusSettingItemRepository;
use App\Repositories\Penjualan\msPromoBonusSettingMerkRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoBonusController extends VierController
{
    public $repository;
    public $repository_bonus_barang;
    public $repository_bonus_item;
    public $repository_bonus_merk;
    public $repository_bonus_supplier;

    public function __construct()
    {
        $this->repository = new msPromoBonusRepository();
        $this->repository_bonus_barang = new msPromoBonusSettingBarangRepository();
        $this->repository_bonus_item = new msPromoBonusSettingItemRepository();
        $this->repository_bonus_merk = new msPromoBonusSettingMerkRepository();
        $this->repository_bonus_supplier = new msPromoBonusSettingSupplier();

        parent::__construct($this->repository);
    }

    public function get_detail()
    {
        try{
            $data = $this->repository->find(request()->id_promo_bonus);
            // $data->item = $this->repository_bonus_item->by_id_promo_bonus();
            $data->barang = $this->repository_bonus_barang->by_id_promo_bonus();
            // $data->merk = $this->repository_bonus_merk->by_id_promo_bonus();
            // $data->supplier = $this->repository_bonus_supplier->by_id_promo_bonus();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
