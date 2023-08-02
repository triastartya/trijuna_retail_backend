<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Helpers\GeneradeNomorHelper;
use App\Repositories\Inventory\mutasiRepository;
use App\Helpers\InventoryStokHelper;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;
use App\Models\Inventory\trMutasi;
use App\Models\Inventory\trMutasiDetail;
use App\Repositories\Master\barangRepository;
use Illuminate\Support\Facades\DB;

class mutasiController extends VierController
{
    public $repository;
    public $barangRepository;
    
    public function __construct()
    {
        $this->repository = new mutasiRepository();
        $this->barangRepository = new barangRepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_deleted'] = 0;
            $data['status_mutasi_warehouse'] = 'OPEN';
            $data['nomor_mutasi'] = GeneradeNomorHelper::long('mutasi warehouse');
            unset($data['detail']);
            $mutasi = trMutasi::create($data);
            foreach($request->detail as $detail){
                $detail['id_mutasi_warehouse'] = $mutasi->id_mutasi_warehouse;

                trMutasiDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi->id_mutasi_warehouse]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function get_by_id(){
        try{
            $data = $this->repository->get_warehouse_by_id_warehouse();
            $data->detail_warehouse = $this->repository->get_warehouse_detail_by_id_pemesanan();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function get_by_param(){
        try{
            $data = $this->repository->get_warehouse_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function validasi(){
        DB::beginTransaction();
        try{
            //=== get update pemesanan
            $mutasi = trMutasi::find(request()->id_mutasi_warehouse);
            if($mutasi->status_mutasi_warehouse == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $mutasi->status_mutasi_warehouse = 'VALIDATED';
            $mutasi->save();
            $mutasi->detail = trMutasiDetail::where('id_mutasi_warehouse',request()->id_mutasi_warehouse)->get();
            //=== update stok
            foreach($mutasi->detail as $detail){
                $inventoryPengurangan = InventoryStokHelper::pengurangan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $mutasi->warehouse_asal,
                    'qty'             => $detail->qty,
                    'nomor_reff'      => $mutasi->id_mutasi_warehouse,
                    'id_header_trans' => $mutasi->id_mutasi_warehouse,
                    'id_detail_trans' => $detail->id_mutasi_warehouse_detail,
                    'jenis'           => 'Mutasi Warehouse Asal',
                    'nominal'         => $detail->sub_total
                ]);
                if(!$inventoryPengurangan[0]){
                    throw new \Exception($inventoryPengurangan[1]);
                }
                $inventoryPenambahan = InventoryStokHelper::penambahan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $mutasi->warehouse_tujuan,
                    'qty'             => $detail->qty, 
                    'nomor_reff'      => $mutasi->id_mutasi_warehouse,
                    'id_header_trans' => $mutasi->id_mutasi_warehouse,
                    'id_detail_trans' => $detail->id_mutasi_warehouse_detail,
                    'jenis'           => 'Mutasi Warehouse Tujuan',
                    'nominal'         => $detail->sub_total
                ]);
                if(!$inventoryPenambahan[0]){
                    throw($inventoryPenambahan[1]);
                }
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function lookup_barang(){
        try{
            $data = $this->barangRepository->by_id_wharehouse(request()->id_warehouse);
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
