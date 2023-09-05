<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory\trPemusnahan;
use App\Models\Inventory\trPemusnahanDetail;
use App\Repositories\Inventory\pemusnahanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class pemusnahanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new pemusnahanRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_deleted'] = 0;
            $data['status_pemusnahan'] = 'OPEN';
            $data['nomor_pemusnahan'] = GeneradeNomorHelper::long('pemusnahan');
            unset($data['detail']);
            $mutasi = trPemusnahan::create($data);
            foreach($request->detail as $detail){
                $detail['id_pemusnahan'] = $mutasi->id_pemusnahan;
                trPemusnahanDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi->id_pemusnahan]);
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
    
    public function validasi(){
        DB::beginTransaction();
        try{
            //=== get update pemesanan
            $pemusnahan = trPemusnahan::find(request()->id_pemusnahan);
            if($pemusnahan->status_pemusnahan == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $pemusnahan->status_pemusnahan = 'VALIDATED';
            $pemusnahan->save();
            $pemusnahan->detail = trPemusnahanDetail::where('id_pemusnahan',request()->id_pemusnahan)->get();
            //=== update stok
            foreach($pemusnahan->detail as $detail){
                $inventoryPengurangan = InventoryStokHelper::pengurangan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $pemusnahan->id_warehouse,
                    'qty'             => $detail->qty,
                    'nomor_reff'      => $pemusnahan->nomor_pemusnahan,
                    'id_header_trans' => $pemusnahan->id_pemusnahan,
                    'id_detail_trans' => $detail->id_pemusnahan_detail,
                    'jenis'           => 'pemusnahan Bahan',
                    'nominal'         => $detail->sub_total
                ]);
                if(!$inventoryPengurangan[0]){
                    throw new \Exception($inventoryPengurangan[1]);
                }
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$pemusnahan]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
}
