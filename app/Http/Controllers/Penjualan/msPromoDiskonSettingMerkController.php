<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Master\msBarang;
use App\Models\Penjualan\msPromoDiskonSettingBarang;
use App\Repositories\Penjualan\msPromoDiskonSettingMerkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class msPromoDiskonSettingMerkController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoDiskonSettingMerkRepository();
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

    public function insert_barang_promo(){
        DB::beginTransaction();
        try{
            $barangs = msBarang::where('id_merk',request()->id_merk)->get();
            foreach($barangs as $barang){
                msPromoDiskonSettingBarang::create([
                    'id_promo_diskon' => request()->id_promo_diskon,
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
