<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msMember;
use App\Repositories\Master\memberRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class memberController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new memberRepository();

        parent::__construct($this->repository);
    }

    public function tarik(){
        try{
            ini_set('memory_limit',-1);
            ini_set('max_execution_time', 0);
            $data = msMember::get();
            return response()->json(['success'=>true,'data'=>[
                'data' => $data
            ]]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function member_by_param()
    {
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function reset_poin()
    {
        try{
            $data = DB::select("update ms_member set jumlah_poin=0",[]);
            return response()->json(['success'=>true,'data'=>1]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
