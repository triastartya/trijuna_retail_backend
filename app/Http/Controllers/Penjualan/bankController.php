<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\posBank;
use App\Repositories\Penjualan\bankRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Viershaka\Vier\VierController;

class bankController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new bankRepository();
        parent::__construct($this->repository);
    }

    public function import(){
        DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/bank.json');
            $delete =posBank::truncate(); 
            foreach($response as $item){
                posBank::create([
                    'id_bank' =>$item['idBank'],
                    'kode_bank'=>$item['kodeBank'],
                    'nama_bank'=>$item['namaBank'],
                    'biaya' =>$item['biaya'],
                    'is_active' => true,
                ]);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$response]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
