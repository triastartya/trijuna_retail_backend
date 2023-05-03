<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Repositories\Inventory\mutasiRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;
use App\Models\Inventory\trMutasi;
use App\Models\Inventory\trMutasiDetail;
use Illuminate\Support\Facades\DB;

class mutasiController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new mutasiRepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_deleted'] = 0;
            $data['status_mutasi_warehouse'] = 'OPEN';
            unset($data['detail']);
            $mutasi = trMutasi::create($data);
            foreach($request->detail as $detail){
                $detail['id_mutasi_warehouse'] = $mutasi->id_mutasi_warehouse;
                trMutasiDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi->id_mutasi_warehouse]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function get_by_id(){
        try{
            $data = $this->repository->get_warehouse_by_id_warehouse();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function get_by_param(){
        try{
            $data = $this->repository->get_warehouse_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
