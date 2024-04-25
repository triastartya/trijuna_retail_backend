<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Models\Pembelian\trReturKonsinyasi;
use App\Models\Pembelian\trReturKonsinyasiDetail;
use App\Repositories\Pembelian\returKonsinyasiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class returKonsinyasiController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new returKonsinyasiRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_retur'] = 'OPEN';
            $data['nomor_retur_pembelian'] = GeneradeNomorHelper::long('retur pembelian');
            unset($data['detail']);
            $retur_pembelian = trReturKonsinyasi::create($data);
            foreach($request->detail as $detail){
                $detail['id_retur_pembelian'] = $retur_pembelian->id_retur_pembelian;
                trReturKonsinyasiDetail::create($detail);
            }
            
            DB::commit();
            return response()->json(['success'=>true,'data'=>$retur_pembelian->id_retur_pembelian]);
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
            $data->detail = $this->repository->detail_by_id();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function validasi(){
        DB::beginTransaction();
        try{
            //=== get update pemesanan
            $retur_pembelian = trReturKonsinyasi::find(request()->id_retur_pembelian);
            if($retur_pembelian->status_retur == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $retur_pembelian->status_retur = 'VALIDATED';
            $retur_pembelian->save();
            $retur_pembelian->detail = trReturKonsinyasiDetail::where('id_retur_pembelian',request()->id_retur_pembelian)->get();
            //=== update stok
            
            foreach($retur_pembelian->detail as $detail){
                $inventory = InventoryStokHelper::pengurangan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $retur_pembelian->id_warehouse,
                    'qty'             => $detail->qty,
                    'nomor_reff'      => $retur_pembelian->nomor_retur_pembelian,
                    'id_header_trans' => $retur_pembelian->id_retur_pembelian,
                    'id_detail_trans' => $detail->id_retur_pembelian_detail,
                    'jenis'           => 'Retur Konsinyasi',
                    'nominal'         => $detail->sub_total
                ]);
                if(!$inventory[0]){
                    DB::rollBack();
                    throw($inventory[1]);
                }
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$retur_pembelian]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
