<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Models\Inventory\trRepacking;
use App\Models\Inventory\trRepackingDetail;
use App\Repositories\Inventory\repackingRepository;
use App\Repositories\Master\barangUraiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class repackingController extends VierController
{
    public $repository;
    public $barangUraiRepository;
    
    public function __construct()
    {
        $this->repository = new repackingRepository();
        $this->barangUraiRepository = new barangUraiRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_deleted'] = 0;
            $data['status_repacking'] = 'OPEN';
            $data['nomor_repacking'] = GeneradeNomorHelper::long('repacking');
            unset($data['detail']);
            $mutasi = trRepacking::create($data);
            foreach($request->detail as $detail){
                $detail['id_repacking'] = $mutasi->id_repacking;
                trRepackingDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi->id_repacking]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
    
    public function lookup_barang(){
        try{
            $data = $this->barangUraiRepository->by_id_barang();
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
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
            $repacking = trRepacking::find(request()->id_repacking);
            if($repacking->status_repacking == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $repacking->status_repacking = 'VALIDATED';
            $repacking->save();
            $repacking->detail = trRepackingDetail::where('id_repacking',request()->id_repacking)->get();
            //=== update stok header
            $inventoryPengurangan = InventoryStokHelper::pengurangan((object)[
                'id_barang'       => $repacking->id_barang,
                'nama_barang'     => '',
                'id_warehouse'    => $repacking->id_warehouse,
                'qty'             => $repacking->qty_repacking, 
                'nomor_reff'      => $repacking->nomor_repacking,
                'id_header_trans' => $repacking->id_repacking,
                'id_detail_trans' => $repacking->id_repacking,
                'jenis'           => 'repacking Hasil',
                'nominal'         => $repacking->total_hpp_avarage_repacking
            ]);
            if(!$inventoryPengurangan[0]){
                DB::rollBack();
                throw new \Exception($inventoryPengurangan[1]);
            }
            //=== update stok
            foreach($repacking->detail as $detail){
                $inventoryPenambahan = InventoryStokHelper::penambahan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $repacking->id_warehouse,
                    'qty'             => $detail->qty,
                    'nomor_reff'      => $repacking->nomor_repacking,
                    'id_header_trans' => $repacking->id_repacking,
                    'id_detail_trans' => $detail->id_repacking_detail,
                    'jenis'           => 'repacking Bahan',
                    'nominal'         => $detail->sub_total
                ]);
                if(!$inventoryPenambahan[0]){
                    DB::rollBack();
                    throw new \Exception($inventoryPenambahan[1]);
                }
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$repacking]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
