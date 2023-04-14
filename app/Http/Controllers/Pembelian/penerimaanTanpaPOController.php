<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Models\Pembelian\trPenerimaanTanpaPo;
use App\Models\Pembelian\trPenerimaanTanpaPoDetail;
use App\Repositories\Pembelian\pemesananRepository;
use App\Repositories\Pembelian\penerimaanTanpaPORepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class penerimaanTanpaPOController extends VierController
{
    public $repository;
    public $repository_pemesanan;
    
    public function __construct()
    {
        $this->repository = new penerimaanTanpaPORepository();
        $this->repository_pemesanan = new pemesananRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_penerimaan'] = 'OPEN';
            $data['jenis_penerimaan'] = 2;
            $data['nomor_penerimaan'] = GeneradeNomorHelper::long('penerimaan tanpa po');
            unset($data['detail']);
            $penerimaan = trPenerimaanTanpaPo::create($data);
            foreach($request->detail as $detail){
                $detail['id_penerimaan'] = $penerimaan->id_penerimaan;
                $penerimaanDetail= trPenerimaanTanpaPoDetail::create($detail);
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
            //=== get update pemesanan
            $penerimaan = trPenerimaanTanpaPo::find(request()->id_penerimaan);
            if($penerimaan->status_penerimaan == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $penerimaan->status_penerimaan = 'VALIDATED';
            $penerimaan->save();
            $penerimaan->detail = trPenerimaanTanpaPoDetail::where('id_penerimaan',request()->id_penerimaan)->get();
            //=== update stok
            
            foreach($penerimaan->detail as $detail){
                InventoryStokHelper::penambahan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $penerimaan->id_warehouse,
                    'qty'             => $detail->qty + $detail->qty_bonus,
                    'nomor_reff'      => $penerimaan->nomor_penerimaan,
                    'id_header_trans' => $penerimaan->id_penerimaan,
                    'id_detail_trans' => $detail->id_penerimaan_detail,
                    'jenis'           => 'Penerimaan Tanpa PO',
                    'nominal'         => $detail->sub_total
                ]);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }    
}
