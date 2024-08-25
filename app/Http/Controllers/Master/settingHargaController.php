<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msBarang;
use App\Models\Master\trSettingHarga;
use App\Models\Master\trSettingHargaDetail;
use App\Models\Master\trSettingHargaDetailLokasi;
use App\Repositories\Master\settingHargaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class settingHargaController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new settingHargaRepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            unset($data['detail']);
            $settingHarga = trSettingHarga::create($data);
            foreach($request->detail as $detail){
                $data_detail = $detail;
                unset($data_detail['lokasi']);
                $data_detail['tanggal_mulai_berlaku'] = $data['tanggal_mulai_berlaku'];
                $data_detail['id_setting_harga'] = $settingHarga->id_setting_harga;
                $update_master = msBarang::where('id_barang',$data_detail['id_barang'])->update([
                    'harga_jual' => $data_detail['harga_jual']
                ]);
                $trSettingHargaDetail = trSettingHargaDetail::create($data_detail);
                foreach($detail['lokasi'] as $lokasi){
                    trSettingHargaDetailLokasi::create([
                        'id_setting_harga_detail' => $trSettingHargaDetail->id_setting_harga_detail,
                        'id_lokasi' =>$lokasi
                    ]);
                }
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$settingHarga->id_setting_harga]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
    
    public function by_param()
    {
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function by_id()
    {
        try{
            $data = $this->repository->by_id();
            $data->detail = $this->repository->detail_by_id_setting_harga();
            foreach($data->detail as $key => $value){
                $data->detail[$key]->lokasi = $this->repository->detail_lokasi_by_id_setting_harga_detail($value->id_setting_harga_detail);
            }
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
