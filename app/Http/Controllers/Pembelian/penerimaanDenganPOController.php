<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Models\Master\msBarang;
use App\Models\Pembelian\trPemesanan;
use App\Models\Pembelian\trPemesananDetail;
use App\Models\Pembelian\trPenerimaan;
use App\Models\Pembelian\trPenerimaanDetail;
use App\Repositories\Pembelian\pemesananRepository;
use App\Repositories\Pembelian\penerimaanDenganPORepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class penerimaanDenganPOController extends VierController
{
    public $repository;
    public $repository_pemesanan;
    
    public function __construct()
    {
        $this->repository = new penerimaanDenganPORepository();
        $this->repository_pemesanan = new pemesananRepository();
        parent::__construct($this->repository);
    }
    
    public function lookup_pemesanan()
    {
        try{
            $data = $this->repository_pemesanan->get_pemesanan_by_param_open();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function lookup_barang()
    {
        try{
            $data = $this->repository_pemesanan->get_pemesanan_detail_by_id_pemesanan_for_penerimaan();
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $pemesanan = trPemesanan::where('id_pemesanan',$request->id_pemesanan)->first();
            $data = $request->all();
            $data['id_supplier'] = $pemesanan->id_supplier;
            $data['status_penerimaan'] = 'OPEN';
            $data['jenis_penerimaan'] = 1;
            $data['nomor_penerimaan'] = GeneradeNomorHelper::long('penerimaan dengan po');
            unset($data['detail']);
            $penerimaan = trPenerimaan::create($data);
            $pemesanan = trPemesanan::where('id_pemesanan',$data['id_pemesanan'])
                            ->update([
                                'status_pemesanan' => 'DITERIMA'
                            ]);
            foreach($request->detail as $detail){
                $master_barang = msBarang::where('id_barang',$detail['id_barang'])->first();
                $detail['harga_beli_sebelumnya'] = $master_barang->harga_beli_terakhir;
                $detail['selisih'] = $master_barang->harga_beli_terakhir - $detail['harga_order'];
                $detail['netto'] = $detail['harga_order'] + ($detail['harga_order'] * 0.11);
                $detail['harga_jual'] = $master_barang->harga_jual;
                $detail['id_penerimaan'] = $penerimaan->id_penerimaan;
                $detail['diskon_persen_1'] = ($detail['diskon_persen_1'])?$detail['diskon_persen_1']:0;
                $detail['diskon_nominal_1'] = ($detail['diskon_nominal_1'])?$detail['diskon_nominal_1']:0;
                $detail['diskon_persen_2'] = ($detail['diskon_persen_2'])?$detail['diskon_persen_2']:0;
                $detail['diskon_nominal_2'] = ($detail['diskon_nominal_2'])?$detail['diskon_nominal_2']:0;
                $detail['diskon_persen_3'] = ($detail['diskon_persen_3'])?$detail['diskon_persen_3']:0;
                $detail['diskon_nominal_3'] = ($detail['diskon_nominal_3'])?$detail['diskon_nominal_3']:0;
                $detail['qty_bonus'] = ($detail['qty_bonus'])?$detail['qty_bonus']:0;
                $penerimaanDetail= trPenerimaanDetail::create($detail);
                $pemesananDetail = trPemesananDetail::where('id_pemesanan_detail',$detail['id_pemesanan_detail'])->first();
                $pemesananDetail->qty_terima = $pemesananDetail->qty_terima + $data['qty'];
                $pemesananDetail->save();
            }
            
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan->id_penerimaan]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
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
    
    public function get_by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->detail = $this->repository->detail_by_id_penerimaan();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function validasi(){
        DB::beginTransaction();
        try{
            //=== get update pemesanan
            $penerimaan = trPenerimaan::where('id_penerimaan',request()->id_penerimaan)->first();
            if($penerimaan->status_penerimaan == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $penerimaan->status_penerimaan  = 'VALIDATED';
            $penerimaan->sub_total1         = request()->sub_total1;
            $penerimaan->diskon_persen      = request()->diskon_persen;
            $penerimaan->diskon_nominal     = request()->diskon_nominal;
            $penerimaan->sub_total2         = request()->sub_total2;
            $penerimaan->ppn_nominal        = request()->ppn_nominal;
            $penerimaan->pembulatan         = request()->pembulatan;
            $penerimaan->total_transaksi    = request()->total_transaksi;
            $penerimaan->total_biaya_barcode= request()->total_biaya_barcode;
            $penerimaan->save();
            $penerimaan->detail = trPenerimaanDetail::where('id_penerimaan',request()->id_penerimaan)->get();
            //=== update stok
            foreach(request()->detail as $detail){

                $penerimaan_detail                  = trPenerimaanDetail::where('id_penerimaan_detail',$detail['id_penerimaan_detail'])->first();
                $penerimaan_detail->harga_order     = $detail['harga_order'];
                $penerimaan_detail->diskon_persen_1 = $detail['diskon_persen_1'];
                $penerimaan_detail->diskon_nominal_1= $detail['diskon_nominal_1'];
                $penerimaan_detail->diskon_persen_2 = $detail['diskon_persen_2'];
                $penerimaan_detail->diskon_nominal_2= $detail['diskon_nominal_2'];
                $penerimaan_detail->diskon_persen_3 = $detail['diskon_persen_3'];
                $penerimaan_detail->diskon_nominal_3= $detail['diskon_nominal_3'];
                $penerimaan_detail->sub_total       = $detail['sub_total'];
                $penerimaan_detail->qty_bonus       = $detail['qty_bonus'];
                $penerimaan_detail->nama_bonus      = $detail['nama_bonus'];
                $penerimaan_detail->biaya_barcode   = $detail['biaya_barcode'];
                $penerimaan_detail->save();
                
                InventoryStokHelper::penambahan((object)[
                    'id_barang'       => $detail['id_barang'],
                    'nama_barang'     => '',
                    'id_warehouse'    => $penerimaan->id_warehouse,
                    'qty'             => $detail['qty'] + $detail['qty_bonus'],
                    'nomor_reff'      => $penerimaan->nomor_penerimaan,
                    'id_header_trans' => $penerimaan->id_penerimaan,
                    'id_detail_trans' => $detail['id_penerimaan_detail'],
                    'jenis'           => 'Penerimaan Dengan PO',
                    'nominal'         => $detail['sub_total']
                ]);

                if(request()->is_update_harga_order){
                    msBarang::where('id_barang',$detail['id_barang'])
                    ->update([
                        'harga_order' => $detail['harga_order'],
                    ]);
                }

                msBarang::where('id_barang',$detail['id_barang'])
                ->update([
                    'harga_beli_terakhir' => $detail['harga_order']
                ]);

                InventoryStokHelper::hitung_hpp_avarage($detail['id_barang'],$detail['qty'],$detail['sub_total']);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
