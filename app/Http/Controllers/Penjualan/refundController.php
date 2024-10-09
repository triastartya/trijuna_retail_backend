<?php

namespace App\Http\Controllers\Penjualan;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Http\Controllers\Controller;
use App\Models\Penjualan\posRefund;
use App\Models\Penjualan\posRefundDetail;
use App\Repositories\Penjualan\refundRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class refundController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new refundRepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['no_retur_penjualan'] = GeneradeNomorHelper::long('refund');
            unset($data['detail']);
            $refund = posRefund::create($data);
            foreach($request->detail as $detail){
                $detail['id_refund'] = $refund->id_refund;
                $refund_detail =posRefundDetail::create($detail);
                InventoryStokHelper::penambahan((object)[
                    'id_barang'       => $detail['id_barang'],
                    'nama_barang'     => '',    
                    'id_warehouse'    => 2,
                    'qty'             => $detail['qty_jual'],
                    'nomor_reff'      => $data['no_retur_penjualan'],
                    'id_header_trans' => $refund->id_refund,
                    'id_detail_trans' => $refund_detail->id_refund_detail,
                    'jenis'           => 'Retur Penjualan Kasir',
                    'nominal'         => $detail['sub_total'] // hpp avarage * qty
                ]);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$refund]);
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
            $data->detail = $this->repository->get_detail();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
