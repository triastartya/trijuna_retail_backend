<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msSatuan;
use App\Repositories\Master\satuanRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class satuanController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new satuanRepository();

        parent::__construct($this->repository);
    }

    public function import(){
        // DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/satuan.json');
            $delete =msSatuan::truncate(); 
            $data = [];
            foreach($response as $item){
                $data[] = [
                    'kode_satuan'=>$item['kodeSatuan'],
                    'nama_satuan'=>$item['satuan'],
                    'created_by'=>1,
                    'updated_by'=>1
                ];
            }
            // dd($data);
            msSatuan::insert($data);
            // DB::commit();
            return response()->json(['success'=>true,'data'=>$data]);
        }
        catch(\Exception $err) {
            // DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
