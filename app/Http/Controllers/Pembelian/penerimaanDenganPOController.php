<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Models\Master\msBarang;
use App\Models\Master\msSupplier;
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
            // if($data['diskon_persen']==0){
                if($data['diskon_nominal']!=0){
                    $data['diskon_persen'] = number_format(($data['diskon_nominal']/$data['sub_total1'])*100);
                }
            // }
            foreach($request->detail as $detail){
                $master_barang = msBarang::where('id_barang',$detail['id_barang'])->first();
                $d1 = ($detail['diskon_nominal_1'])?$detail['diskon_nominal_1']/$detail['qty']:0;
                $d2 = ($detail['diskon_nominal_2'])?$detail['diskon_nominal_2']/$detail['qty']:0;
                $d3 = ($detail['diskon_nominal_3'])?$detail['diskon_nominal_3']/$detail['qty']:0;
                $harga_order_bersih_atas = $detail['harga_order'] - $d1 - $d2 - $d3;
                $dfooter = ($data['diskon_persen']==0)?0:($data['diskon_persen']/100)*$harga_order_bersih_atas;
                $harga_order_bersih_bawah = $harga_order_bersih_atas - $dfooter;
                $ppn = ($data['is_ppn']==true)?$harga_order_bersih_bawah * 0.11:0;
                $detail['netto'] = $harga_order_bersih_bawah + $ppn;
                $detail['harga_beli_sebelumnya'] = $master_barang->harga_beli_terakhir;
                $detail['selisih'] = $master_barang->harga_beli_terakhir - $detail['netto'];
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
                // $pemesananDetail = trPemesananDetail::where('id_pemesanan_detail',$detail['id_pemesanan_detail'])->first();
                // $pemesananDetail->qty_terima = $pemesananDetail->qty_terima + $data['qty'];
                // $pemesananDetail->save();
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
            $pemesanan = trPemesanan::where('id_pemesanan',$data->id_pemesanan)->first();
            $data->id_supplier = $pemesanan->id_supplier;
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
            if($penerimaan->status_penerimaan == 'CANCEL'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah di cancel']);
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
            $supplier = msSupplier::where('id_supplier',$penerimaan->id_supplier)->first();
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
                    'nominal'         => $detail['sub_total'],
                    'keterangan'      => 'Penerimaan Dengan PO '.$supplier->nama_supplier,
                    'transaksi'       => 'tr_penerimaan'
                ]);

                if(request()->is_update_harga_order){
                    msBarang::where('id_barang',$detail['id_barang'])
                    ->update([
                        'harga_order' => $detail['harga_beli_netto'],
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

    public function edit_lama(){
        try {
            $data = request()->all();
            $id_penerimaan = 0;
            trPenerimaanDetail::where('id_penerimaan',$data[0]['id_penerimaan'])->delete();
            foreach($data as $detail){
                // unset($detail['id_penerimaan_detail']);
                // unset($detail['barcode']);
                // unset($detail['kode_barang']);
                // unset($detail['nama_barang']);
                // unset($detail['nama_satuan']);
                $master_barang = msBarang::where('id_barang',$detail['id_barang'])->first();
                $d = $detail;
                $d['harga_beli_sebelumnya'] = $master_barang->harga_beli_terakhir;
                $d['selisih'] = $master_barang->harga_beli_terakhir - $detail['harga_order'];
                $d['netto'] = $detail['harga_order'] + ($detail['harga_order'] * 0.11);
                $d['harga_jual'] = $master_barang->harga_jual;
                $d['diskon_persen_1'] = ($detail['diskon_persen_1'])?$detail['diskon_persen_1']:0;
                $d['diskon_nominal_1'] = ($detail['diskon_nominal_1'])?$detail['diskon_nominal_1']:0;
                $d['diskon_persen_2'] = ($detail['diskon_persen_2'])?$detail['diskon_persen_2']:0;
                $d['diskon_nominal_2'] = ($detail['diskon_nominal_2'])?$detail['diskon_nominal_2']:0;
                $d['diskon_persen_3'] = ($detail['diskon_persen_3'])?$detail['diskon_persen_3']:0;
                $d['diskon_nominal_3'] = ($detail['diskon_nominal_3'])?$detail['diskon_nominal_3']:0;
                $d['qty_bonus'] = ($detail['qty_bonus'])?$detail['qty_bonus']:0;
                $d['netto'] = ($detail['harga_beli_netto'])?$detail['harga_beli_netto']:0;
                $id_penerimaan = $detail['id_penerimaan'];
                // unset($d['harga_beli_netto']);
                $penerimaanDetail= trPenerimaanDetail::create($d);
            }
            $qty = array_reduce($data, function($sum, $item) {
                return $sum + $item['qty'];
            }, 0);
            // dd($qty);
            
            $sub_total = array_reduce($data, function($sum, $item) {
                return $sum + $item['sub_total'];
            }, 0);
            // dd($sub_total);
            $penerimaan = trPenerimaan::where('id_penerimaan',$id_penerimaan)->first();
           
            $ppn = ($sub_total-$penerimaan->diskon_nominal)*0.11;
            
            $penerimaan->qty = $qty;
            $penerimaan->sub_total1 = $sub_total;
            $penerimaan->sub_total2 = $sub_total-$penerimaan->diskon_nominal;
            $penerimaan->ppn_nominal = $ppn;
            $penerimaan->total_transaksi = $sub_total - $penerimaan->diskon_nominal - $ppn + $penerimaan->pembulatan;
            $penerimaan->save();
            // dd($data);
            DB::commit();
            return response()->json(['success'=>true,'data'=>$id_penerimaan]);
        } catch (\Exception $ex) {
            // throw  $ex;
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function edit(Request $request){
        DB::beginTransaction();
        try {
            $cek = trPenerimaan::where('id_penerimaan',request()->id_penerimaan)->first();
            if($cek->status_penerimaan == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $data = $request->all();
            $data['jenis_penerimaan'] = 1;
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
            $penerimaan = trPenerimaan::where('id_penerimaan',$request->id_penerimaan)->update($data);
            trPenerimaanDetail::where('id_penerimaan',$request->id_penerimaan)->delete();
            // if($data['diskon_persen']==0){
                if($data['diskon_nominal']!=0){
                    $data['diskon_persen'] = number_format(($data['diskon_nominal']/$data['sub_total1'])*100);
                }
            // }
            $urut= 0;
            foreach($request->detail as $detail){
                $urut++;
                unset($detail['id_penerimaan_detail']);
                $master_barang = msBarang::where('id_barang',$detail['id_barang'])->first();
                $d1 = ($detail['diskon_nominal_1'])?$detail['diskon_nominal_1']/$detail['qty']:0;
                $d2 = ($detail['diskon_nominal_2'])?$detail['diskon_nominal_2']/$detail['qty']:0;
                $d3 = ($detail['diskon_nominal_3'])?$detail['diskon_nominal_3']/$detail['qty']:0;
                $harga_order_bersih_atas = $detail['harga_order'] - $d1 - $d2 - $d3;
                $dfooter = ($data['diskon_persen']==0)?0:($data['diskon_persen']/100)*$harga_order_bersih_atas;
                $harga_order_bersih_bawah = $harga_order_bersih_atas - $dfooter;
                $ppn = ($data['is_ppn']==true)?$harga_order_bersih_bawah * 0.11:0;
                $detail['netto'] = $harga_order_bersih_bawah + $ppn;
                $detail['harga_beli_sebelumnya'] = $master_barang->harga_beli_terakhir;
                $detail['urut'] = $urut;
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
                $penerimaanDetail= trPenerimaanDetail::create($detail);
            }
            
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan]);
        }
        catch(\Exception $err) {
            // throw $err;
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function pembatalan(){
        DB::beginTransaction();
        try{
            //=== get update pemesanan
            $penerimaan = trPenerimaan::where('id_penerimaan',request()->id_penerimaan)->first();
            if($penerimaan->status_penerimaan == 'CANCEL'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si cancel']);
            }
            $penerimaan->status_penerimaan  = 'CANCEL';
            $penerimaan->save();
            $detail = trPenerimaanDetail::where('id_penerimaan',request()->id_penerimaan)->get();
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
                    'jenis'           => 'Penerimaan Dengan PO',
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

    public function perbaikan_netto(){
        try{
            $data = DB::select('
                select 
                    tpd.*,
                    tp.diskon_persen as diskon,
                    tp.tanggal_nota as tanggal,
                    tp.is_ppn,tp.ppn_nominal
                from tr_penerimaan_detail tpd 
                inner join tr_penerimaan tp on tpd.id_penerimaan=tp.id_penerimaan
                where tp.tanggal_nota BETWEEN ? and ?
            ',[request()->start,request()->end]);
            foreach($data as $key=>$item){
                $harga_order_bersih_atas = $item->harga_order - $item->diskon_nominal_1 - $item->diskon_nominal_2 - $item->diskon_nominal_3;
                $dfooter = ($item->diskon==0)?0:($item->diskon/100)*$harga_order_bersih_atas;
                $harga_order_bersih_bawah = $harga_order_bersih_atas - $dfooter;
                $ppn = ($item->ppn_nominal>0)?$harga_order_bersih_bawah * 0.11:0;
                $netto =  $harga_order_bersih_bawah + $ppn;
                trPenerimaanDetail::where('id_penerimaan_detail',$item->id_penerimaan_detail)
                ->update([
                    'netto'=>$netto
                ]);
            }
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
