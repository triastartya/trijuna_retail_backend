<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\GeneradeNomorHelper;
use App\Models\Finance\trBayarHutang;
use App\Models\Finance\trBayarHutangPelunasan;
use App\Models\Finance\trBayarHutangPelunasanCash;
use App\Models\Finance\trBayarHutangPelunasanGiro;
use App\Models\Finance\trBayarHutangPelunasanTransfer;
use App\Repositories\Finance\bayarHutangPelunasanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class bayarHutangPelunasanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new bayarHutangPelunasanRepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['nomor_pelunasan'] = GeneradeNomorHelper::long('pelunasan');
            unset($data['detail_transfer']);
            unset($data['detail_cash']);
            unset($data['detail_giro']);
            $bayar_hutang_pelunasan = trBayarHutangPelunasan::create($data);
            trBayarHutang::where('id_bayar_hutang',$request->id_bayar_hutang)
            ->update([
                'is_lunas'=>true,
                'id_bayar_hutang_pelunasan'=>$bayar_hutang_pelunasan->id_bayar_hutang_pelunasan,
                'tanggal_lunas'=>$request->tanggal_bayar
            ]);
            foreach($request->detail_transfer as $detail){
                $detail['id_bayar_hutang_pelunasan'] = $bayar_hutang_pelunasan->id_bayar_hutang_pelunasan;
                trBayarHutangPelunasanTransfer::create($detail);
            }
            foreach($request->detail_cash as $detail){
                $detail['id_bayar_hutang_pelunasan'] = $bayar_hutang_pelunasan->id_bayar_hutang_pelunasan;
                trBayarHutangPelunasanCash::create($detail);
            }
            foreach($request->detail_giro as $detail){
                $detail['id_bayar_hutang_pelunasan'] = $bayar_hutang_pelunasan->id_bayar_hutang_pelunasan;
                trBayarHutangPelunasanGiro::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$bayar_hutang_pelunasan->id_bayar_hutang_pelunasan]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function get_by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->transfer = $this->repository->get_transfer();
            $data->giro = trBayarHutangPelunasanGiro::where('id_bayar_hutang_pelunasan',$data->id_bayar_hutang_pelunasan)->get();
            $data->cash = trBayarHutangPelunasanCash::where('id_bayar_hutang_pelunasan',$data->id_bayar_hutang_pelunasan)->get();
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
}
