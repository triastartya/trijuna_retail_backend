<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Pembelian\trPemesanan;
use App\Models\Pembelian\trPemesananDetail;
use App\Repositories\Pembelian\pemesananRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pemesananController extends VierController
{
    public function __construct()
    {
        $repository = new pemesananRepository();

        parent::__construct($repository);
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_pemesanan'] = 'OPEN';
            $data['nomor_pemesanan'] = GeneradeNomorHelper::long('pemesanan');
            unset($data['detail']);
            $pemesanan = trPemesanan::create($data);
            foreach($request->detail as $detail){
                $detail['id_pemesanan'] = $pemesanan->id_pemesanan;
                trPemesananDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$pemesanan->id_pemesanan]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
    
    public function get_by_id(){
        try{
            $data = $this->repository->get_pemesanan_by_id_pemesanan();
            $data->detail_pemesanan = $this->repository->get_pemesanan_detail_by_id_pemesanan();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function get_by_param(){
        try{
            $data = $this->repository->get_pemesanan_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

}
