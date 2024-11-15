<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Models\Master\msBarang;
use App\Models\Master\msSupplier;
use App\Models\Pembelian\trPenerimaanTanpaPo;
use App\Models\Pembelian\trPenerimaanTanpaPoDetail;
use App\Repositories\Pembelian\pemesananRepository;
use App\Repositories\Pembelian\penerimaanTanpaPORepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class penerimaanTanpaPOController extends VierController
{
    public $repository;
    public $repository_pemesanan;
    
    public function __construct()
    {
        $this->repository = new penerimaanTanpaPORepository();
        $this->repository_pemesanan = new pemesananRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_penerimaan'] = 'OPEN';
            $data['jenis_penerimaan'] = 2;
            $data['nomor_penerimaan'] = GeneradeNomorHelper::long('penerimaan tanpa po');
            $data['total_biaya_barcode'] = 0;
            unset($data['detail']);
            $penerimaan = trPenerimaanTanpaPo::create($data);
            if($data['diskon_persen']==0){
                if($data['diskon_nominal']!=0){
                    $data['diskon_persen'] = number_format(($data['diskon_nominal']/$data['sub_total1'])*100);
                }
            }
            $urut= 0;
            foreach($request->detail as $detail){
                $urut++;
                $ppn = ($data['is_ppn']==true)?$detail['harga_order'] * 0.11:0;
                $master_barang = msBarang::where('id_barang',$detail['id_barang'])->first();
                $d1 = ($detail['diskon_nominal_1'])?$detail['diskon_nominal_1']/$detail['qty']:0;
                $d2 = ($detail['diskon_nominal_2'])?$detail['diskon_nominal_2']/$detail['qty']:0;
                $d3 = ($detail['diskon_nominal_3'])?$detail['diskon_nominal_3']/$detail['qty']:0;
                $dfooter = ($data['diskon_persen']==0)?0:($data['diskon_persen']/100)*$detail['harga_order'];
                $detail['harga_beli_sebelumnya'] = $master_barang->harga_beli_terakhir;
                $detail['urut'] = $urut;
                $detail['netto'] = $detail['harga_order'] + $ppn - $d1 - $d2 - $d3 - $dfooter ;
                $detail['selisih'] = $master_barang->harga_beli_terakhir - $detail['netto'];
                $detail['harga_jual'] = $master_barang->harga_jual;
                $detail['id_penerimaan'] = $penerimaan->id_penerimaan;
                $detail['biaya_barcode'] = 0;
                $penerimaanDetail= trPenerimaanTanpaPoDetail::create($detail);
            }
            
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan->id_penerimaan]);
        }
        catch(\Exception $err) {
            throw $err;
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
            $penerimaan = trPenerimaanTanpaPo::find(request()->id_penerimaan);
            if($penerimaan->status_penerimaan == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            if($penerimaan->status_penerimaan == 'CANCEL'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si cancel']);
            }
            $penerimaan->status_penerimaan = 'VALIDATED';
            $penerimaan->save();
            $penerimaan->detail = trPenerimaanTanpaPoDetail::where('id_penerimaan',request()->id_penerimaan)->get();
            //=== update stok
            $supplier = msSupplier::where('id_supplier',$penerimaan->id_supplier)->first();
            foreach($penerimaan->detail as $detail){
                InventoryStokHelper::penambahan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $penerimaan->id_warehouse,
                    'qty'             => $detail->qty + $detail->qty_bonus,
                    'nomor_reff'      => $penerimaan->nomor_penerimaan,
                    'id_header_trans' => $penerimaan->id_penerimaan,
                    'id_detail_trans' => $detail->id_penerimaan_detail,
                    'jenis'           => 'Penerimaan Tanpa PO',
                    'nominal'         => $detail->sub_total,
                    'keterangan'      => 'Penerimaan Tanpa PO '.$supplier->nama_supplier,
                    'transaksi'       => 'tr_penerimaan'
                ]);
                if(request()->is_update_harga_order){
                    msBarang::where('id_barang',$detail->id_barang)
                    ->update([
                        'harga_order' => $detail->harga_order,
                    ]);
                }
                msBarang::where('id_barang',$detail->id_barang)
                    ->update([
                        'harga_beli_terakhir' => $detail->netto
                    ]);
                InventoryStokHelper::hitung_hpp_avarage($detail->id_barang,$detail->qty,$detail->sub_total);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function edit(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['jenis_penerimaan'] = 2;
            $cek = trPenerimaanTanpaPo::find(request()->id_penerimaan);
            if($cek->status_penerimaan == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            unset($data['detail']);
            unset($data['nomor_pemesanan']);
            unset($data['nama_supplier']);
            //==== hitung
            $qty = array_reduce($request->detail, function($sum, $item) {
                return $sum + $item['qty'];
            }, 0);
            $sub_total = array_reduce($request->detail, function($sum, $item) {
                return $sum + $item['sub_total'];
            }, 0);
            $data['qty'] = $qty;
            $data['sub_total1'] = $sub_total;
            $data['sub_total2'] = $sub_total - $data['diskon_nominal'];
            $data['total_transaksi'] = $data['sub_total2'] + $data['ppn_nominal'] + $data['potongan'] + $data['pembulatan'];
            $penerimaan = trPenerimaanTanpaPo::where('id_penerimaan',$request->id_penerimaan)->update($data);
            trPenerimaanTanpaPoDetail::where('id_penerimaan',$request->id_penerimaan)->delete();
            if($data['diskon_persen']==0){
                if($data['diskon_nominal']!=0){
                    $data['diskon_persen'] = number_format(($data['diskon_nominal']/$data['sub_total1'])*100);
                }
            }
            $urut= 0;
            foreach($request->detail as $detail){
                $urut++;
                unset($detail['id_penerimaan_detail']);
                $ppn = ($data['is_ppn']==true)?$detail['harga_order'] * 0.11:0;
                $master_barang = msBarang::where('id_barang',$detail['id_barang'])->first();
                $d1 = ($detail['diskon_nominal_1'])?$detail['diskon_nominal_1']/$detail['qty']:0;
                $d2 = ($detail['diskon_nominal_2'])?$detail['diskon_nominal_2']/$detail['qty']:0;
                $d3 = ($detail['diskon_nominal_3'])?$detail['diskon_nominal_3']/$detail['qty']:0;
                $dfooter = ($data['diskon_persen']==0)?0:($data['diskon_persen']/100)*$detail['harga_order'];
                $detail['harga_beli_sebelumnya'] = $master_barang->harga_beli_terakhir;
                $detail['urut'] = $urut;
                $detail['netto'] = $detail['harga_order'] + $ppn - $d1 - $d2 - $d3 - $dfooter ;
                $detail['selisih'] = $master_barang->harga_beli_terakhir - $detail['netto'];
                $detail['harga_jual'] = $master_barang->harga_jual;
                $detail['id_penerimaan'] = $data['id_penerimaan'];
                $detail['diskon_persen_1'] = ($detail['diskon_persen_1'])?$detail['diskon_persen_1']:0;
                $detail['diskon_nominal_1'] = ($detail['diskon_nominal_1'])?$detail['diskon_nominal_1']:0;
                $detail['diskon_persen_2'] = ($detail['diskon_persen_2'])?$detail['diskon_persen_2']:0;
                $detail['diskon_nominal_2'] = ($detail['diskon_nominal_2'])?$detail['diskon_nominal_2']:0;
                $detail['diskon_persen_3'] = ($detail['diskon_persen_3'])?$detail['diskon_persen_3']:0;
                $detail['diskon_nominal_3'] = ($detail['diskon_nominal_3'])?$detail['diskon_nominal_3']:0;
                $detail['qty_bonus'] = ($detail['qty_bonus'])?$detail['qty_bonus']:0;
                $penerimaanDetail= trPenerimaanTanpaPoDetail::create($detail);
            }
            
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan]);
        }
        catch(\Exception $err) {
            throw $err;
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function pembatalan(){
        DB::beginTransaction();
        try{
            //=== get update pemesanan
            $penerimaan = trPenerimaanTanpaPo::where('id_penerimaan',request()->id_penerimaan)->first();
            if($penerimaan->status_penerimaan == 'CANCEL'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si cancel']);
            }
            $penerimaan->status_penerimaan  = 'CANCEL';
            $penerimaan->save();
            $detail = trPenerimaanTanpaPoDetail::where('id_penerimaan',request()->id_penerimaan)->get();
            //=== update stok
            $supplier = msSupplier::where('id_supplier',$penerimaan->id_supplier)->first();
            foreach($detail as $detail){
                InventoryStokHelper::pengurangan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $penerimaan->id_warehouse,
                    'qty'             => $detail->qty + $detail->qty_bonus,
                    'nomor_reff'      => $penerimaan->nomor_penerimaan,
                    'id_header_trans' => $penerimaan->id_penerimaan,
                    'id_detail_trans' => $detail->id_penerimaan_detail,
                    'jenis'           => 'Penerimaan Tanpa Dengan PO',
                    'nominal'         => $detail->sub_total,
                    'keterangan'      => 'Cancel Penerimaan Dengan PO '.$supplier->nama_supplier. ',nomor penerimaan '.$penerimaan->nomor_penerimaan,
                    'transaksi'       => 'tr_penerimaan'
                ]);
                InventoryStokHelper::hitung_hpp_avarage($detail->id_barang,$detail->qty,$detail->sub_total);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

}
