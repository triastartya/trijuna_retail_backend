<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Finance\trBayarHutang;
use App\Models\Finance\trBayarHutangFaktur;
use App\Models\Finance\trBayarHutangPotongan;
use App\Models\Finance\trBayarHutangPotonganLain;
use App\Models\Pembelian\trPenerimaan;
use App\Models\Pembelian\trReturPembelian;
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
            // dd($data);
            $data['nomor_titip_tagihan'] = GeneradeNomorHelper::long('bayar hutang');
            unset($data['detail_faktur']);
            unset($data['detail_retur']);
            unset($data['detail_potongan']);
            $bayar_hutang = trBayarHutang::create($data);
            foreach($request->detail_faktur as $detail){
                $detail['id_bayar_hutang'] = $bayar_hutang->id_bayar_hutang;
                trBayarHutangFaktur::create($detail);
                trPenerimaan::where('id_penerimaan',$detail['id_penerimaan'])
                ->update([
                    'is_lunas'=>true,
                    'id_billing'=>$bayar_hutang->id_bayar_hutang
                ]);
            }
            foreach($request->detail_retur as $detail){
                $detail['id_bayar_hutang'] = $bayar_hutang->id_bayar_hutang;
                trBayarHutangPotongan::create($detail);
                trReturPembelian::where('id_retur_pembelian',$detail['id_retur_pembelian'])
                ->update([
                    'is_lunas'=>true,
                    'id_billing'=>$bayar_hutang->id_bayar_hutang
                ]);
            }
            foreach($request->detail_potongan as $detail){
                $detail['id_bayar_hutang'] = $bayar_hutang->id_bayar_hutang;
                trBayarHutangPotonganLain::create($detail);
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
            $data->retur = $this->repository->detail_potongan_by_id();
            $data->potongan = trBayarHutangPotonganLain::where('id_bayar_hutang',request()->id_bayar_hutang)->get();
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

    public function get_data_belum_lunas(){
        try{
            $nota = trPenerimaan::where('is_lunas',false)
                ->where('id_supplier',request()->id_supplier)->get();
            $retur = trReturPembelian::where('is_lunas',false)
                ->where('id_supplier',request()->id_supplier)->get();
            return response()->json(['success'=>true,'data'=>[
                'nota_pembelian' => $nota,
                'retur_pembelian' => $retur
            ]]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    // BAYAR TT
    public function tt_belum_terbayar(){
        try{
            $data = $this->repository->get_tt_belum_by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        }catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

}
