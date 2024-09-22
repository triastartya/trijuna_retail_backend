<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\trFakturPajak;
use App\Models\Pembelian\trPenerimaan;
use App\Repositories\Finance\fakturPajakRepository;
use App\Repositories\Pembelian\penerimaanDenganPORepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class fakturPajakController extends VierController
{
    public $repository;
    public $repository_penerimaan_po;
    
    public function __construct()
    {
        $this->repository = new fakturPajakRepository();
        $this->repository_penerimaan_po = new penerimaanDenganPORepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $faktur_pajak = trFakturPajak::create($data);
            $update = trPenerimaan::where('id_penerimaan',$request->id_penerimaan)
            ->update([
                'faktur_pajak'=>true,
                'id_faktur_pajak'=>$faktur_pajak->id_faktur_pajak
            ]);
            DB::commit();
            return response()->json(['success'=>true,'data'=>$faktur_pajak]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function get_penerimaan_belum_faktur_pajak_by_param(){
        try{
            $data = $this->repository_penerimaan_po->by_param_faktur_pajak();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function get_by_id(){
        try{
            $data = $this->repository->get_by_id();
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
