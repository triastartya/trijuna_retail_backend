<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\posEdc;
use App\Repositories\Penjualan\edcRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Viershaka\Vier\VierController;

class edcController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new edcRepository();
        parent::__construct($this->repository);
    }

    public function import(){
        DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/edc.json');
            $delete =posEdc::truncate(); 
            foreach($response as $item){
                posEdc::create([
                    'id_edc' =>$item['idEdc'],
                    'kode_edc'=>$item['kodeEdc'],
                    'nama_edc'=>$item['namaEdc'],
                    'keterangan' =>$item['keterangan'],
                    'is_active' => true
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
