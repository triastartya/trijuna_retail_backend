<?php

namespace App\Http\Controllers\Inventory;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Inventory\trSettingStokOpname;
use App\Models\Inventory\trSettingStokOpnameBarang;
use App\Models\Inventory\trSettingStokOpnameDivisi;
use App\Models\Inventory\trSettingStokOpnameGroup;
use App\Models\Inventory\trSettingStokOpnameSupplier;
use App\Repositories\Inventory\trSettingStokOpnameRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

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
            DB::commit();
            return response()->json(['success'=>true,'data'=>$so->id_setting_stok_opname]);
        }
        catch(\Exception $err) {
            DB::rollBack();
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
}
