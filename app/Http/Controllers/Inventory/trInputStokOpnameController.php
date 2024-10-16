<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\trInputStokOpname;
use App\Models\Inventory\trInputStokOpnameDetail;
use App\Models\Inventory\trSettingStokOpname;
use App\Repositories\Inventory\trInputStokOpnameRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;
use Illuminate\Support\Facades\Auth;


class trInputStokOpnameController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new trInputStokOpnameRepository();
        parent::__construct($this->repository);
    }

    public function get_setting_open(){
        $data = $this->repository->setting_so_open_by_param();
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function get_barang_by_setting_so(){
        try{
            $data = $this->repository->get_barang_by_setting_so();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function insert(Request $request){
        try{
            $data = $request->all();
            $data['id_user'] = Auth::user()->id_user;
            $stokopname = trInputStokOpname::create($data);
            foreach($request->detail as $detail){
                $detail['id_input_stok_opname'] = $stokopname->id_input_stok_opname;
                trInputStokOpnameDetail::create($detail);
            }
            return response()->json(['success'=>true,'data'=>$stokopname->id_input_stok_opname]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
