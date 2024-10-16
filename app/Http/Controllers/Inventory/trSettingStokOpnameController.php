<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
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
            return $err;
            // return response()->json(['success'=>false,'message'=>$err->getMessage()]);
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
}
