<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msDivisi;
use App\Repositories\Master\divisiRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class divisiController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new divisiRepository();

        parent::__construct($this->repository);
    }

    public function import_divisi(){
        DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/divisi.json');
            $delete =msDivisi::truncate(); 
            foreach($response as $item){
                msDivisi::create([
                    'id_divisi' =>$item['idDivisi'],
                    'kode_divisi'=>$item['kodeDivisi'],
                    'divisi'=>$item['divisi']
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
