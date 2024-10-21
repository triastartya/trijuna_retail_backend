<?php

namespace App\Http\Controllers\Penjualan;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Http\Controllers\Controller;
use App\Models\Penjualan\posPenjualan;
use App\Models\Penjualan\posPenjualanDetail;
use App\Models\Penjualan\posPenjualanPayment;
use App\Models\User;
use App\Repositories\Penjualan\penjualanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class penjualanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new penjualanRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $cek = posPenjualan::where('nota_penjualan',$request->no_faktur)->first();
            if($cek){
                throw new \Exception('duplikat no faktur');
            }
            $data = $request->all();
            $data['nota_penjualan'] = $request->no_faktur;
            unset($data['detail']);
            $data['is_bayar'] = true;
            $penjualan = posPenjualan::create($data);
            $user = User::where('id_user',$penjualan->id_user_kasir)->frist();
            foreach($request->detail as $detail){
                $detail['id_penjualan'] = $penjualan->id_penjualan;
                $penjualan_detail =posPenjualanDetail::create($detail);
                InventoryStokHelper::pengurangan((object)[
                    'id_barang'       => $detail['id_barang'],
                    'nama_barang'     => '',
                    'id_warehouse'    => 2,
                    'qty'             => $detail['qty_jual'],
                    'nomor_reff'      => $data['nota_penjualan'],
                    'id_header_trans' => $penjualan->id_penjualan,
                    'id_detail_trans' => $penjualan_detail->id_penjualan_detail,
                    'jenis'           => 'Penjualan Kasir',
                    'nominal'         => $detail['sub_total'], // hpp avarage * qty
                    'keterangan'      => 'Penjualan '.$user->nama
                ]);
            }
            foreach($request->payment as $payment){
                $payment['id_penjualan'] = $penjualan->id_penjualan;
                posPenjualanPayment::create($payment);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penjualan->id_penjualan]);
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
            $data->payment = $this->repository->get_payment();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function get_by_no_nota(){
        try{
            $data = $this->repository->get_by_nota();
            $data->detail = $this->repository->get_detail($data->id_penjualan);
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

    public function sell_out_item(){
        try{
            $data = $this->repository->sell_out_item();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function minimal(){
        return response()->json(['success'=>true,'data'=>[
            [
                "minimalGesekID" => 1, 
                "jenisKartu" => "KARTU DEBIT", 
                "salesPaymentMethodID" => 4, 
                "minimalGesek" => 50000 
            ],
            [
                "minimalGesekID" => 2, 
                "jenisKartu" => "KARTU KREDIT", 
                "salesPaymentMethodID" => 5, 
                "minimalGesek" => 100000 
            ]
        ]]);
    }
}
