<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Finance\trBayarHutang;
use App\Models\Finance\trBayarHutangFaktur;
use App\Models\Finance\trBayarHutangPotongan;
use App\Repositories\Finance\bayarHutangRepository;
use App\Repositories\Master\supplierRepository;
use App\Repositories\Pembelian\penerimaanDenganPORepository;
use App\Repositories\Pembelian\returPembelianRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class bayarHutangController extends VierController
{
    public $repository;
    public $repository_supplier;
    public $repository_retur_pembelian;
    public $repository_penerimaan;
    
    public function __construct()
    {
        $this->repository = new bayarHutangRepository();
        $this->repository_supplier = new supplierRepository();
        $this->repository_retur_pembelian = new returPembelianRepository();
        $this->repository_penerimaan = new penerimaanDenganPORepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['nomor_titip_tagihan'] = GeneradeNomorHelper::long('bayar hutang');
            unset($data['detail']);
            $bayar_hutang = trBayarHutang::create($data);
            foreach($request->detail_faktur as $detail){
                $detail['id_bayar_hutang'] = $bayar_hutang->id_bayar_hutang;
                trBayarHutangFaktur::create($detail);
            }
            foreach($request->detail_potongan as $detail){
                $detail['id_bayar_hutang'] = $bayar_hutang->id_bayar_hutang;
                trBayarHutangPotongan::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$bayar_hutang->id_bayar_hutang]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function get_by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->faktur = $this->repository->detail_faktur_by_id();
            $data->potongan = $this->repository->detail_potongan_by_id();
            $data->payment = $this->repository->detail_payment_by_id();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function get_by_param(){
        try{
            $data = $this->repository->get_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function lookup_supplier(){
        try{
            $data = $this->repository_supplier->by_param_active();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function lookup_penerimaan_belum_lunas(){
        try{
            $data = $this->repository_penerimaan->belum_lunas();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function lookup_retur_potong_tagihan(){
        try{
            $data = $this->repository_retur_pembelian->belum_lunas_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

}
