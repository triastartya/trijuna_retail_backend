<?php

namespace App\Http\Controllers\Master;

use App\Helpers\LokasiHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\msBarang;
use App\Models\Master\msBarangVersion;
use App\Models\Master\msLokasi;
use App\Models\Master\trSettingHarga;
use App\Models\Master\trSettingHargaDetail;
use App\Models\Master\trSettingHargaDetailLokasi;
use App\Repositories\Master\settingHargaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;
use Illuminate\Support\Facades\Http;

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
                    'harga_jual' => $data_detail['harga_jual'],
                    'qty_grosir1' => $data_detail['qty_grosir1'],
                    'harga_grosir1' => $data_detail['harga_grosir1'],
                    'qty_grosir2' => $data_detail['qty_grosir2'],
                    'harga_grosir2' => $data_detail['harga_grosir2'],
                ]);
                $trSettingHargaDetail = trSettingHargaDetail::create($data_detail);
                foreach($detail['lokasi'] as $lokasi){
                    $use = LokasiHelper::use();
                    $kirim = '';
                    $ket = '';
                    if($use->id_lokasi != $lokasi){
                        try {
                            $lokasi_kirim = msLokasi::where('id_lokasi',$lokasi)->first();
                            $brng = msBarang::where('id_barang',$data_detail['id_barang'])->first();
                            $request = [
                                "id_lokasi" => $lokasi,
                                "tanggal_mulai_berlaku" => $data['tanggal_mulai_berlaku'],
                                "detail" => [
                                    [
                                        "id_barang"     => $data_detail['id_barang'],
                                        "kode_barang"   => $brng->kode_barang,
                                        "nama_barang"   => $brng->nama_barang,
                                        "harga_jual"    => $data_detail['harga_jual'],
                                        "qty_grosir1"   => $data_detail['qty_grosir1'],
                                        "harga_grosir1" => $data_detail['harga_grosir1'],
                                        "qty_grosir2"   => $data_detail['qty_grosir2'],
                                        "harga_grosir2" => $data_detail['harga_grosir2'],
                                        "lokasi"        => [],
                                    ],
                                ],
                            ];
                            // dd($request);
                            $response = Http::withOptions(['verify' => false])->post($lokasi_kirim->server.'/api/setting_harga_api',$request);
                            
                            if ($response->successful()) {
                                $res = $response->object();
                                // dd($res);
                                if($res->success){
                                    $kirim = 'berhasil';
                                    $ket = 'berhasil';
                                }else{
                                    $kirim = 'gagal';
                                    $ket = $res->message;
                                }
                            } else {
                                $kirim = 'gagal';
                                $ket = $response->status().', err';
                            }
                        } catch (\Exception $err ) {
                            $kirim = 'gagal';
                            $ket = $err->getMessage();
                        }
                    }
                    trSettingHargaDetailLokasi::create([
                        'id_setting_harga_detail' => $trSettingHargaDetail->id_setting_harga_detail,
                        'id_lokasi' =>$lokasi,
                        'kirim'=>$kirim,
                        'keterangan'=>$ket
                    ]);
                }
            }
            $version = msBarangVersion::where('id_barang_version',1)->first();
            $version->version = $version->version+1;
            $version->save();
            DB::commit();
            return response()->json(['success'=>true,'data'=>$settingHarga->id_setting_harga]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function insertbyapi(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            unset($data['detail']);
            $settingHarga = trSettingHarga::create($data);
            foreach($request->detail as $detail){
                $data_detail = $detail;
                $cek_barang = msBarang::where('kode_barang',$data_detail['kode_barang'])->first();
                if(!$cek_barang){
                    DB::rollBack();
                    return response()->json(['success'=>false,'message'=>'kode barang tidak di temukan '.$data_detail['kode_barang'].' '.$data_detail['nama_barang']]);
                }
                $data_detail['id_barang'] = $cek_barang->id_barang; // input id barang sesuai id barang yang ada di lokasi tujuan
                $data_detail['tanggal_mulai_berlaku'] = $data['tanggal_mulai_berlaku'];
                $data_detail['id_setting_harga'] = $settingHarga->id_setting_harga;
                $update_master = msBarang::where('id_barang',$data_detail['id_barang'])->update([
                    'harga_jual' => $data_detail['harga_jual'],
                    'qty_grosir1' => $data_detail['qty_grosir1'],
                    'harga_grosir1' => $data_detail['harga_grosir1'],
                    'qty_grosir2' => $data_detail['qty_grosir2'],
                    'harga_grosir2' => $data_detail['harga_grosir2'],
                ]);
                unset($data_detail['kode_barang']);
                unset($data_detail['nama_barang']);
                $trSettingHargaDetail = trSettingHargaDetail::create($data_detail);
            }
            $version = msBarangVersion::where('id_barang_version',1)->first();
            $version->version = $version->version+1;
            $version->save();
            DB::commit();
            return response()->json(['success'=>true,'data'=>$data]);
        }catch(\Exception $err) {
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
