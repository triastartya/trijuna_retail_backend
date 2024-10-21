<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\InventoryStokHelper;
use App\Models\Inventory\trProduksi;
use App\Models\Inventory\trProduksiDetail;
use App\Repositories\Inventory\produksiRepository;
use App\Repositories\Master\barangKomponenRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class produksiController extends VierController
{
    public $repository;
    public $barangKomponenRepository;
    
    public function __construct()
    {
        $this->repository = new produksiRepository();
        $this->barangKomponenRepository = new barangKomponenRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['is_deleted'] = 0;
            $data['status_produksi'] = 'OPEN';
            $data['nomor_produksi'] = GeneradeNomorHelper::long('produksi');
            unset($data['detail']);
            $mutasi = trProduksi::create($data);
            foreach($request->detail as $detail){
                $detail['id_produksi'] = $mutasi->id_produksi;
                trProduksiDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$mutasi->id_produksi]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
    
    public function lookup_barang(){
        try{
            $data = $this->barangKomponenRepository->by_id_barang();
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
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
    
    public function validasi(){
        DB::beginTransaction();
        try{
            //=== get update pemesanan
            $produksi = trProduksi::find(request()->id_produksi);
            if($produksi->status_produksi == 'VALIDATED'){
                return response()->json(['success'=>false,'data'=>[],'message'=>'transaksi ini sudah si validasi']);
            }
            $produksi->status_produksi = 'VALIDATED';
            $produksi->save();
            $produksi->detail = trProduksiDetail::where('id_produksi',request()->id_produksi)->get();
            //=== update stok header
            $inventoryPenambahan = InventoryStokHelper::penambahan((object)[
                'id_barang'       => $produksi->id_barang,
                'nama_barang'     => '',
                'id_warehouse'    => $produksi->id_warehouse,
                'qty'             => $produksi->qty_produksi, 
                'nomor_reff'      => $produksi->nomor_produksi,
                'id_header_trans' => $produksi->id_produksi,
                'id_detail_trans' => $produksi->id_produksi,
                'jenis'           => 'Produksi Hasil',
                'nominal'         => $produksi->total_hpp_avarage_produksi,
                'keterangan'      => 'Produksi Hasil dari nomor dokumen'.$produksi->nomor_produksi,
            ]);
            if(!$inventoryPenambahan[0]){
                DB::rollBack();
                throw new \Exception($inventoryPenambahan[1]);
            }
            //=== update stok
            foreach($produksi->detail as $detail){
                $inventoryPengurangan = InventoryStokHelper::pengurangan((object)[
                    'id_barang'       => $detail->id_barang,
                    'nama_barang'     => '',
                    'id_warehouse'    => $produksi->id_warehouse,
                    'qty'             => $detail->qty,
                    'nomor_reff'      => $produksi->nomor_produksi,
                    'id_header_trans' => $produksi->id_produksi,
                    'id_detail_trans' => $detail->id_produksi_detail,
                    'jenis'           => 'Produksi Bahan',
                    'nominal'         => $detail->sub_total,
                    'keterangan'      => 'Produksi Untuk Bahan dari nomor dokumen'.$produksi->nomor_produksi,
                ]);
                if(!$inventoryPengurangan[0]){
                    DB::rollBack();
                    throw new \Exception($inventoryPengurangan[1]);
                }
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$produksi]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}