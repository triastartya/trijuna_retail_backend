<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory\trMutasiLokasi;
use App\Models\Inventory\trMutasiLokasiDetail;
use App\Models\Master\msLokasi;
use App\Repositories\Inventory\mutasiLokasiRepository;
use App\Repositories\Master\barangRepository;
use App\Repositories\Master\LokasiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class mutasiLokasiController extends VierController
{
    public $repository;
    public $barangRepository;
    public $lokasiRepository;
    
    public function __construct()
    {
        $this->repository = new mutasiLokasiRepository();
        $this->barangRepository =  new barangRepository();
        $this->lokasiRepository = new LokasiRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_deleted'] = 0;
            $data['status_mutasi_lokasi'] = 'OPEN';
            $data['nomor_mutasi_lokasi'] = GeneradeNomorHelper::long('mutasi lokasi');
            unset($data['detail']);
            $mutasi = trMutasiLokasi::create($data);
            foreach($request->detail as $detail){
                $detail['id_mutasi_lokasi'] = $mutasi->id_mutasi_lokasi;
                trMutasiLokasiDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi->id_mutasi_lokasi]);
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
    
    public function lookup_barang(){
        try{
            $data = $this->barangRepository->by_id_wharehouse(request()->id_warehouse);
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function lookup_lokasi(){
        try{
            $data = $this->lokasiRepository->get_lokasi_status_online();
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
