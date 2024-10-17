<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory\trInputStokOpnameDetail;
use App\Models\Inventory\trSettingStokOpname;
use App\Models\Inventory\trSettingStokOpnameBarang;
use App\Models\Inventory\trSettingStokOpnameCapture;
use App\Models\Inventory\trSettingStokOpnameDivisi;
use App\Models\Inventory\trSettingStokOpnameGroup;
use App\Models\Inventory\trSettingStokOpnameSupplier;
use App\Models\Master\msBarang;
use App\Models\Master\msBarangKartuStok;
use App\Models\Master\msBarangStok;
use App\Repositories\Inventory\trSettingStokOpnameRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\select;

class trSettingStokOpnameController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new trSettingStokOpnameRepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['nomor_stok_opname'] = GeneradeNomorHelper::long('setting stok opname');
            $data['status'] = 'OPEN';
            unset($data['detail_barang']);
            unset($data['detail_divisi']);
            unset($data['detail_group']);
            unset($data['detail_supplier']);
            $so = trSettingStokOpname::create($data);
            foreach($request->detail_barang as $detail){
                $detail['id_setting_stok_opname'] = $so->id_setting_stok_opname;
                trSettingStokOpnameBarang::create($detail);
            }
            foreach($request->detail_divisi as $detail){
                $detail['id_setting_stok_opname'] = $so->id_setting_stok_opname;
                trSettingStokOpnameDivisi::create($detail);
            }
            foreach($request->detail_group as $detail){
                $detail['id_setting_stok_opname'] = $so->id_setting_stok_opname;
                trSettingStokOpnameGroup::create($detail);
            }
            foreach($request->detail_supplier as $detail){
                $detail['id_setting_stok_opname'] = $so->id_setting_stok_opname;
                trSettingStokOpnameSupplier::create($detail);
            }

            switch (strtoupper(request()->jenis_stok_opname)) {
                case "DIVISI":
                    $divisi = [];
                    foreach(request()->detail_divisi as $detail){
                        $divisi[] =  $detail['id_divisi'];
                    }
                    $item = msBarang::whereIn('id_divisi',$divisi)->get();
                    break;
                case "GROUP":
                    $group = [];
                    foreach(request()->detail_group as $detail){
                        $group[] =  $detail['id_group'];
                    }
                    $item = msBarang::whereIn('id_group',$group)->get();
                    break;
                case "SUPPLIER":
                    $supplier = [];
                    foreach(request()->detail_supplier as $detail){
                        $supplier[] =  $detail['id_supplier'];
                    }
                    $item = msBarang::whereIn('id_supplier',$supplier)->get();
                    break;
                default:
                    $barang = [];
                    foreach(request()->detail_barang as $detail){
                        $barang[] =  $detail['id_barang'];
                    }
                    $item = msBarang::whereIn('id_barang',$barang)->get();
                    break;
            }
            // dd($item);
            foreach($item as $barang){
                $stock_capture = msBarangKartuStok::where('id_barang',$barang->id_barang)
                ->where('id_warehouse',request()->id_warehouse)
                ->where('created_at','<=',request()->tanggal_setting_stok_opname)
                ->orderBy('created_at', 'desc')
                ->first();
                // dd($stock_capture);
                trSettingStokOpnameCapture::create([
                    'id_setting_stok_opname' =>$so->id_setting_stok_opname,
                    'id_barang'=>$barang->id_barang,
                    'tanggal_setting_stok_opname'=>$so->tanggal_setting_stok_opname,
                    'qty_capture'=> ($stock_capture)?$stock_capture->stok_akhir:0,
                    'hpp_average'=>$barang->hpp_average,
                    'harga_jual'=>$barang->harga_jual
                ]);
            }

            DB::commit();
            return response()->json(['success'=>true,'data'=>$so->id_setting_stok_opname]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            // return $err;
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function by_id(){
        try{
            $data = $this->repository->get_by_id();
            $data->detail_barang = $this->repository->detail_barang();
            $data->detail_supplier = $this->repository->detail_supplier();
            $data->detail_group = $this->repository->detail_group();
            $data->detail_divisi = $this->repository->detail_divisi();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function by_param(){
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function kalkulasi(){
        try{
            $data = $this->repository->get_barang_by_setting_so();
            foreach($data as $key=>$barang){
                $query = DB::select("select sum(tisod.qty_fisik) as qty_fisik
                from tr_input_stok_opname_detail tisod
                inner join tr_input_stok_opname tiso on tisod.id_input_stok_opname=tiso.id_input_stok_opname
                where tiso.id_setting_stok_opname=? and tisod.id_barang=?",[request()->id_setting_stok_opname,$barang->id_barang]);
                $get_qty_fisik = $query[0];
                $qty_fisik = ($get_qty_fisik->qty_fisik)?$get_qty_fisik->qty_fisik:0;
                $data[$key]->qty_fisik = $qty_fisik;    
                $data[$key]->qty_selisih = $barang->qty_capture - $qty_fisik;
                $data[$key]->sub_total_fisik_harga_jual = $data[$key]->qty_fisik * $barang->harga_jual;
                $data[$key]->sub_total_capture_harga_jual = $barang->qty_capture * $barang->harga_jual;
                $data[$key]->sub_total_selisih_harga_jual = $data[$key]->qty_selisih * $barang->harga_jual;
                $data[$key]->sub_total_fisik_hpp_average = $data[$key]->qty_fisik * $barang->hpp_average;
                $data[$key]->sub_total_capture_hpp_average = $barang->qty_capture * $barang->hpp_average;
                $data[$key]->sub_total_selisih_hpp_average = $data[$key]->qty_selisih * $barang->hpp_average;
            }
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function finalisasi(){
        DB::beginTransaction();
        try {
            $settingSO = trSettingStokOpname::where('id_setting_stok_opname',request()->id_setting_stok_opname)->first();
            if($settingSO->status =="FINALISASI"){
                throw new \Exception('data setting stok opname sudah di finalisasi');
            }
            $settingSO->status = "FINALISASI";
            $settingSO->finalisasi_at = date('Y-m-d H:i:s');
            $settingSO->finalisasi_by = Auth::user()->id_user;
            $settingSO->finalisasi_keterangan = request()->keterangan;
            $settingSO->save();
            // kalkulasi 
            $data = $this->repository->get_barang_by_setting_so();
            foreach($data as $key=>$barang){

                $query = DB::select("select sum(tisod.qty_fisik) as qty_fisik
                from tr_input_stok_opname_detail tisod
                inner join tr_input_stok_opname tiso on tisod.id_input_stok_opname=tiso.id_input_stok_opname
                where tiso.id_setting_stok_opname=? and tisod.id_barang=?",[request()->id_setting_stok_opname,$barang->id_barang]);
                $get_qty_fisik = $query[0];
                $qty_fisik = ($get_qty_fisik->qty_fisik)?$get_qty_fisik->qty_fisik:0;

                trSettingStokOpnameCapture::where('id_setting_stok_opname_capture',$barang->id_setting_stok_opname_capture)
                ->update([
                    "qty_fisik" => $qty_fisik,
                    "qty_selisih" =>  $qty_fisik - $barang->qty_capture,
                    "sub_total_fisik_harga_jual" =>  $qty_fisik * $barang->harga_jual,
                    "sub_total_capture_harga_jual" => $barang->qty_capture * $barang->harga_jual,
                    "sub_total_selisih_harga_jual" =>  ($qty_fisik - $barang->qty_capture) * $barang->harga_jual,
                    "sub_total_fisik_hpp_average" =>  $qty_fisik * $barang->hpp_average,
                    "sub_total_capture_hpp_average" => $barang->qty_capture * $barang->hpp_average,
                    "sub_total_selisih_hpp_average" =>  ($qty_fisik - $barang->qty_capture) * $barang->hpp_average
                ]);
                // kartu stok
                // dd($qty_fisik - $barang->qty_capture);
                $insert_kartu_stok = msBarangKartuStok::create([
                    'tanggal' => $settingSO->tanggal_setting_stok_opname,
                    'created_at' => $settingSO->tanggal_setting_stok_opname,
                    'updated_at' => $settingSO->tanggal_setting_stok_opname,
                    'id_barang' => $barang->id_barang,
                    'id_warehouse' => $settingSO->id_warehouse,
                    'nomor_reff' => $settingSO->nomor_stok_opname,
                    'id_header_trans' => $settingSO->id_setting_stok_opname,
                    'id_detail_trans' => $barang->id_setting_stok_opname_capture,
                    'stok_awal' => $barang->qty_capture,
                    'nominal_awal' => ($barang->qty_capture) * $barang->hpp_average,
                    'stok_masuk' => ($qty_fisik - $barang->qty_capture>0)?$qty_fisik - $barang->qty_capture:0,
                    'nominal_masuk' => ($qty_fisik - $barang->qty_capture>0)?($qty_fisik - $barang->qty_capture) * $barang->hpp_average:0,
                    'stok_keluar' => ($qty_fisik - $barang->qty_capture<0)?$qty_fisik - $barang->qty_capture:0,
                    'nominal_keluar' => ($qty_fisik - $barang->qty_capture<0)?($qty_fisik - $barang->qty_capture) * $barang->hpp_average:0,
                    'stok_akhir' => $qty_fisik - $barang->qty_capture,
                    'nominal_akhir' => ($qty_fisik - $barang->qty_capture) * $barang->hpp_average,
                    'keterangan' => 'stok opname , tanggal '.$settingSO->tanggal_setting_stok_opname.', nomor SO '.$settingSO->nomor_stok_opname
                ]);
                
                $kartustok = msBarangKartuStok::where('id_barang',$barang->id_barang)
                    ->where('id_warehouse',request()->id_warehouse)
                    ->where('created_at','>=',$settingSO->tanggal_setting_stok_opname)
                    ->orderBy('created_at', 'asc')
                    ->get();
                $stok_awal = 0;
                foreach($kartustok as $key=>$kartu){
                    if($key!=0){
                        $stok_akhir = $kartu->stok_awal+$kartu->stok_masuk-$kartu->stok_keluar;
                        msBarangKartuStok::where('id_kartu_stok')
                        ->update([
                            'stok_awal'=>$stok_awal,
                            'stok_akhir'=>$stok_akhir
                        ]);
                        $stok_awal = $stok_awal + $stok_akhir;
                    }else{
                        $stok_awal = $kartu->stok_akhir;
                    }
                }
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$settingSO]);
        }catch(\Exception $err) {
            DB::rollBack();
            // return $err;
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
