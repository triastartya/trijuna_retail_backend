<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Models\Pembelian\trPemesanan;
use App\Models\Pembelian\trPemesananDetail;
use App\Models\Pembelian\trPenerimaan;
use App\Models\Pembelian\trPenerimaanDetail;
use App\Repositories\Pembelian\pemesananRepository;
use App\Repositories\Pembelian\penerimaanDenganPORepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class penerimaanDenganPOController extends VierController
{
    public $repository;
    public $repository_pemesanan;
    
    public function __construct()
    {
        $this->repository = new penerimaanDenganPORepository();
        $this->repository_pemesanan = new pemesananRepository();
        parent::__construct($this->repository);
    }
    
    public function lookup_pemesanan()
    {
        try{
            $data = $this->repository_pemesanan->get_pemesanan_by_param_open();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function lookup_barang()
    {
        try{
            $data = $this->repository_pemesanan->get_pemesanan_detail_by_id_pemesanan_for_penerimaan();
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_penerimaan'] = 'OPEN';
            $data['jenis_penerimaan'] = 1;
            $data['nomor_penerimaan'] = GeneradeNomorHelper::long('penerimaan');
            unset($data['detail']);
            $penerimaan = trPenerimaan::create($data);
            $pemesanan = trPemesanan::where('id_pemesanan',$data['id_pemesanan'])
                            ->update([
                                'status_pemesanan' => 'DITERIMA'
                            ]);
            foreach($request->detail as $detail){
                $detail['id_penerimaan'] = $penerimaan->id_penerimaan;
                trPenerimaanDetail::create($detail);
                $pemesananDetail = trPemesananDetail::where('id_pemesanan_detail',$detail['id_pemesanan_detail'])->first();
                $pemesananDetail->qty_terima = $pemesananDetail->qty_terima - $data['qty'];
                $pemesananDetail->save();
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan->id_penerimaan]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
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
    
    public function get_by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->detail = $this->repository->detail_by_id_penerimaan();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function validasi(){
        DB::beginTransaction();
        try{
            $update = trPenerimaan::where('id_penerimaan',request()->id_penerimaan)
                        ->update('status_penerimaan','validated');
            DB::commit();
            return response()->json(['success'=>true,'data'=>$update]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
