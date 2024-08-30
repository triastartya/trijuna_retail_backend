<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory\trMutasi;
use App\Models\Inventory\trMutasiDetail;
use App\Models\Inventory\trMutasiLokasi;
use App\Models\Inventory\trMutasiLokasiDetail;
use App\Models\Master\msLokasi;
use App\Repositories\Inventory\mutasiLokasiRepository;
use App\Repositories\Master\barangRepository;
use App\Repositories\Master\LokasiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Viershaka\Vier\VierController;

class mutasiKeluarController extends VierController
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
            $lokasi = msLokasi::where('is_use',true)->first();
            $data = $request->all();
            $data['is_deleted'] = 0;
            $data['status_mutasi_lokasi'] = 'OPEN';
            $data['nomor_mutasi_lokasi'] = GeneradeNomorHelper::long('mutasi keluar');
            $data['jenis_mutasi'] = 2 ;
            $data['id_lokasi_asal'] = $lokasi->id_lokasi;
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

    public function by_param(){
        try{
            $data = $this->repository->by_param_keluar();
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
                InventoryStokHelper::pengurangan((object)[
                    'id_barang'       => $detail['id_barang'],
                    'nama_barang'     => '',
                    'id_warehouse'    => $mutasi->warehouse_asal,
                    'qty'             => $detail['qty'],
                    'nomor_reff'      => $mutasi->nomor_mutasi_lokasi,
                    'id_header_trans' => $mutasi->id_mutasi_lokasi,
                    'id_detail_trans' => $detail['id_mutasi_lokasi_detail'],
                    'jenis'           => 'Mutasi Keluar',
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
    public function download(){
        try{
            $data = DB::select("select * from tr_mutasi_lokasi where id_mutasi_lokasi=".request()->id_mutasi_lokasi);
            if(count($data)==0){
                throw new \Exception('data mutasi tidak di temukan');
            }
            if($data[0]->status_mutasi_lokasi!='VALIDATED'){
                throw new \Exception('data mutasi belum di validasi');
            }
            $data[0]->detail = DB::select('select * from tr_mutasi_lokasi_detail where id_mutasi_lokasi = '.request()->id_mutasi_lokasi);
            // Convert array to JSON
            $jsonContent = json_encode($data[0], JSON_PRETTY_PRINT);

            // Create a response with the JSON content
            return Response::make($jsonContent, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$data[0]->nomor_mutasi_lokasi.'-'.$data[0]->tanggal_mutasi_lokasi.'.json"',
            ]);
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
