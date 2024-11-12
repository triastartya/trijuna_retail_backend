<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Master\msBarang;
use App\Models\Penjualan\msPromoHadiahSettingBarang;
use App\Repositories\Penjualan\msPromoHadiahSettingSupplierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class msPromoHadiahSettingSupplierController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoHadiahSettingSupplierRepository();
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

    public function insert_barang_promo(){
        DB::beginTransaction();
        try{
            $barangs = msBarang::where('id_supplier',request()->id_supplier)->get();
            foreach($barangs as $barang){
                msPromoHadiahSettingBarang::create([
                    'id_promo_hadiah' => request()->id_promo_hadiah,
                    'id_barang' => $barang->id_barang
                ]);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$barangs]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
