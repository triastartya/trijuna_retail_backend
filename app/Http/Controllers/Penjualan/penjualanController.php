<?php

namespace App\Http\Controllers\Penjualan;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Penjualan\posPenjualan;
use App\Models\Penjualan\posPenjualanDetail;
use App\Models\Penjualan\posPenjualanPayment;
use App\Repositories\Penjualan\penjualanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class penjualanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new penjualanRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['nota_penjualan'] = GeneradeNomorHelper::long('penjualan');
            unset($data['detail']);
            $data['is_bayar'] = true;
            $penjualan = posPenjualan::create($data);
            foreach($request->detail as $detail){
                $detail['id_penjualan'] = $penjualan->id_penjualan;
                posPenjualanDetail::create($detail);
            }
            foreach($request->payment as $payment){
                $payment['id_penjualan'] = $penjualan->id_penjualan;
                posPenjualanPayment::create($payment);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penjualan->id_penjualan]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
    
    public function get_by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->detail = $this->repository->get_detail();
            $data->payment = $this->repository->get_payment();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function get_by_param(){
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
