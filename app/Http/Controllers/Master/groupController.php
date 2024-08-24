<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msGroup;
use App\Repositories\Master\groupRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class groupController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new groupRepository();

        parent::__construct($this->repository);
    }

    public function import(){
        DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/baru/group.json');
            $delete =msGroup::truncate(); 
            foreach($response['data'] as $item){
                msGroup::create([
                    'id_group' =>$item['idGrup'],
                    'kode_group'=>$item['kodeGrup'],
                    'group'=>$item['grup']
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
