<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Finance\trBayarPiutang;
use App\Models\Finance\trBayarPiutangNota;
use App\Models\Finance\trBayarPiutangPayment;
use App\Repositories\Finance\bayarHutangRepository;
use App\Repositories\Finance\bayarPiutangRepository;
use App\Repositories\Penjualan\penjualanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class bayarPiutangController extends VierController
{
    public $repository;
    public $repository_penjualan;
    public $repository_member;
    
    public function __construct()
    {
        $this->repository = new bayarPiutangRepository();
        $this->repository_penjualan = new penjualanRepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['nomor_titip_tagihan'] = GeneradeNomorHelper::long('bayar piutang');
            unset($data['detail']);
            $bayar_piutang = trBayarPiutang::create($data);
            foreach($request->detail_faktur as $detail){
                $detail['id_bayar_piutang'] = $bayar_piutang->id_bayar_piutang;
                trBayarPiutangNota::create($detail);
            }
            foreach($request->detail_payment as $detail){
                $detail['id_bayar_piutang'] = $bayar_piutang->id_bayar_piutang;
                trBayarPiutangPayment::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$bayar_piutang->id_bayar_piutang]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function get_by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->nota = $this->repository->detail_nota();
            $data->payment = $this->repository->detail_payment();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function get_by_param(){
        try{
            $data = $this->repository->get_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function lookup_nota_belum_lunas(){
        try{
            $data = $this->repository_penjualan->belum_lunas();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function lookup_customer(){
        try{
            $data = $this->repository_member->get_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
