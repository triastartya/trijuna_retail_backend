<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory\trStokOpname;
use App\Models\Inventory\trStokOpnameDetail;
use App\Repositories\Inventory\stokOpnameRepository;
use App\Repositories\Master\barangRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class stokOpnameController extends VierController
{
    public $repository;
    public $repository_barang;
    public function __construct()
    {
        $this->repository = new stokOpnameRepository();
        $this->repository_barang = new barangRepository();
        parent::__construct($this->repository);
    }

    public function lookup_barang(Request $request){
        try {
            $data = $this->repository_barang->by_stokopname($request->id_audit_stok_opname);
            return response()->json(['success'=>true,'data'=>$data]);
        }
        catch(\Exception $err) {
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function insert(Request $request)
    {
        try {
            $data = $request->all();
            $data['status'] = 'OPEN';
            $data['nomor_audit_stok_opname'] = GeneradeNomorHelper::long('stok opname');
            // unset($data['detail']);
            $stokopname = trStokOpname::create($data);
            // foreach($request->detail as $detail){
            //     $detail['id_audit_stok_opname'] = $stokopname->id_audit_stok_opname;
            //     trStokOpnameDetail::create($detail);
            // }
            return response()->json(['success'=>true,'data'=>$stokopname->id_audit_stok_opname]);
        }
        catch(\Exception $err) {
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function insert_detail(Request $request)
    {
        try {
            $count = $this->repository->count_detail();
            $barang = $this->repository->barang();
            $header = $this->repository->get_by_id();
            $capture = $this->repository->capture_from_kartu_stok($header->waktu_capture_stok);
            $data = [
                'id_audit_stok_opname'=>$request->id_audit_stok_opname,
                'no_urut'=>$count+1,
                'id_barang'=>$request->id_barang,
                'harga_jual'=>(float)$barang->harga_jual['harga_jual'],
                'hpp_avarage'=>(float)$barang->hpp_average,
                'waktu_capture_stok'=>$header->waktu_capture_stok,
                'qty_fisik'=>$request->qty_fisik,
                'qty_sistem_capture_stok'=>(float)$capture->stok_akhir,
                'sub_total_fisik'=>((float)$request->qty_fisik*(float)$barang->hpp_average),
                'sub_total_sistem_capture_stok'=>($capture->stok_akhir*(float)$barang->hpp_avarage),
                'qty_proses_selisih'=>($capture->stok_akhir-$request->qty_fisik),
                'sub_total_proses_selisih'=>((float)$capture->stok_akhir-(float)$request->qty_fisik)*(float)$barang->hpp_avarage,
            ];
            // dd($data);
            $stokopname = trStokOpnameDetail::create($data);
            return response()->json(['success'=>true,'data'=>$stokopname->id_audit_stok_opname]);
        }
        catch(\Exception $err) {
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
}
