<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
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

class mutasiMasukController extends VierController
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

            // Validate the file input
            $request->validate([
                'json_file' => 'required|file|mimes:json|max:2048',
            ]);

            // Retrieve the uploaded file
            $file = $request->file('json_file');

            // Read the file contents
            $jsonContents = file_get_contents($file->getRealPath());

            // Decode JSON content
            $request = json_decode($jsonContents, true);
            // dd($request);
            // Check if decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'Invalid JSON file.');
            }
            $lokasi = msLokasi::where('is_use',true)->first();
            $data = (array)$request;
            $data['is_deleted'] = 0;
            $data['status_mutasi_lokasi'] = 'OPEN';
            $data['nomor_mutasi_lokasi'] = GeneradeNomorHelper::long('mutasi masuk');
            $data['jenis_mutasi'] = 1 ;
            $data['id_lokasi_tujuan'] = $lokasi->id_lokasi;
            unset($data['detail']);
            unset($data['id_mutasi_lokasi']);
            unset($data['created_by']);
            unset($data['updated_by']);
            unset($data['created_at']);
            unset($data['updated_at']);
            $mutasi = trMutasiLokasi::create($data);
            foreach($request['detail'] as $detail){
                $detail['id_mutasi_lokasi'] = $mutasi->id_mutasi_lokasi;
                unset($detail['created_at']);
                unset($detail['updated_at']);
                unset($detail['id_mutasi_lokasi_detail']);
                trMutasiLokasiDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi->id_mutasi_lokasi]);
        }
        catch(\Exception $err) {
            throw $err;
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
    
    public function by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->detail = $this->repository->get_detail();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function by_param(){
        try{
            $data = $this->repository->by_param_masuk();
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

    public function validasi(){
        DB::beginTransaction();
        try{
            $mutasi = trMutasiLokasi::where('id_mutasi_lokasi',request()->id_mutasi_lokasi)->first();
            if($mutasi->status_mutasi_lokasi == 'VALIDATED'){
                throw new \Exception('data mutasi sudah di validasi');
            }
            $mutasi->status_mutasi_lokasi = 'VALIDATED';
            $mutasi->save();
            $detail_mutasi = trMutasiLokasiDetail::where('id_mutasi_lokasi',request()->id_mutasi_lokasi)->get();
            foreach($detail_mutasi as $detail){
                InventoryStokHelper::penambahan((object)[
                    'id_barang'       => $detail['id_barang'],
                    'nama_barang'     => '',
                    'id_warehouse'    => $mutasi->warehouse_asal,
                    'qty'             => $detail['qty'],
                    'nomor_reff'      => $mutasi->nomor_mutasi_lokasi,
                    'id_header_trans' => $mutasi->id_mutasi_lokasi,
                    'id_detail_trans' => $detail['id_mutasi_lokasi_detail'],
                    'jenis'           => 'Mutasi Masuk',
                    'nominal'         => $detail['sub_total'] // hpp avarage * qty
                ]);
            }
            DB::commit();
            return response()->json(['status'=>true,'data'=>$mutasi]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

}
