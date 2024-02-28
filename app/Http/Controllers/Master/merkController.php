<?php

namespace App\Http\Controllers\Master;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\msMerk;
use App\Repositories\Master\merkRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class merkController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new merkRepository();

        parent::__construct($this->repository);
    }
    public function import(){
        // DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/merk.json');
            $delete =msMerk::truncate(); 
            $data = [];
            foreach($response as $item){
                $data[] = [
                    'id_merk' =>$item['idMerk'],
                    'merk'=>$item['merk'],
                    'created_by'=>1,
                    'updated_by'=>1
                ];
            }
            msMerk::insert($data);
            // DB::commit();
            return response()->json(['success'=>true,'data'=>$data]);
        }
        catch(\Exception $err) {
            // DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
