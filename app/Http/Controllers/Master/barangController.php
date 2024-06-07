<?php

namespace App\Http\Controllers\Master;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\LokasiHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\msBarang;
use App\Models\Master\msBarangSatuan;
use App\Models\Master\msLokasi;
use App\Models\Master\trSettingHarga;
use App\Models\Master\trSettingHargaDetail;
use App\Repositories\Master\barangRepository;
use DateTime;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class barangController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new barangRepository();
        parent::__construct($this->repository);
    }

    public function tambah(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['kode_barang'] = GeneradeNomorHelper::sort('barang');
            unset($data['id_satuan2']);
            unset($data['isi_satuan2']);
            unset($data['id_satuan3']);
            unset($data['isi_satuan3']);
            unset($data['grosir1']);
            unset($data['harga_grosir1']);
            unset($data['grosir2']);
            unset($data['harga_grosir2']);
            $barang = msBarang::create($data);

            $lokasi = LokasiHelper::use();
            //=== insert setting harga
            $setting_harga = trSettingHarga::create([
                'id_lokasi'=>$lokasi->id_lokasi,
                'tanggal_mulai_berlaku'=> date('Y-m-d H:i:s')
            ]);

            $setting_harga_detail = trSettingHargaDetail::create([
                'tanggal_mulai_berlaku'=>date('Y-m-d H:i:s'),
                'id_setting_harga'=>$setting_harga->id_setting_harga,
                'id_barang'=>$barang->id_barang,
                'harga_jual'=>$request->harga_jual,
                'qty_grosir1'=>$request->qty_grosir1,
                'harga_grosir1'=>$request->harga_grosir1,
                'qty_grosir2'=>$request->qty_grosir2,
                'harga_grosir2'=>$request->harga_grosir2,
                'priority'=>1,
            ]);

            if($request->isi_satuan2!=0 ||$request->isi_satuan2!=null){
                $satuan= msBarangSatuan::create([
                    'id_barang'=>$barang->id_barang,
                    'id_satuan'=>$request->id_satuan2,
                    'isi'       =>$request->isi_satuan2,
                ]);
            }
            
            if($request->isi_satuan3!=0 ||$request->isi_satuan3!=null){
                $satuan= msBarangSatuan::create([
                    'id_barang'=>$barang->id_barang,
                    'id_satuan'=>$request->id_satuan3,
                    'isi'       =>$request->isi_satuan3,
                ]);
            }

            DB::commit();
            return response()->json(['success'=>true,'data'=>$barang->kode_barang]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$ex->getMessage()]);
        }
    }

    public function update_status_active(Request $request){
        try {
            $update = msBarang::where('id_barang',$request->id_barang)->first();
            $update->is_active = !$update->is_active;
            $update->save();
            return response()->json(['success'=>true,'data'=>$update->id_barang]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage()]);
        }
    }

    public function lihat_stok(Request $request){
        try {
            $barang = msBarang::with('stok.warehouse')->where('id_barang',$request->id_barang)->first();
            if(count($barang->stok)!=0){
                $barang->jumlah_stok = collect($barang->stok)->sum('qty');
            }else{
                $barang->jumlah_stok = 0;
            }
            return response()->json(['success'=>true,'data'=>$barang]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage()]);
        }
    }

    public function lihat_stok_cabang(Request $request){
        try {
            $data = msLokasi::all();
            foreach($data as $index=>$lokasi){
                $response = Http::get($lokasi->server.'/api/barang/lihat_stok/'.$request->id_barang);
                if($response->successful()){
                    $data[$index]->stok = [
                        'succsess' => true,
                        'data'=> $response->object(),
                        'message'=>""
                    ];
                }else{
                    $data[$index]->stok = [
                        'succsess' => false,
                        'data'=> null,
                        'message'=>$response->status().", ".$response->body()
                    ];
                }
                // $data[$index]->stok = [
                //     'succsess' => false,
                //     'data'=> null,
                //     'message'=>$ex
                // ];
            }
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage()]);
        }
    }

    public function ubah(){
        try {
            
        } catch (\Exception $th) {
            
        }
    }
    
    public function barang_by_param(){
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function barang_pos(){
        try{
            $data = $this->repository->barang_pos();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function import(){
        DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/barang.json');
            msBarang::truncate(); 
            trSettingHarga::truncate();
            trSettingHargaDetail::truncate();
            $data_barang = [];
            $data_setting_harga = [];
            $setting= trSettingHarga::create([
                 'id_lokasi' => 1,
                 'tanggal_mulai_berlaku' => new DateTime()
            ]);
            foreach($response as $item){
                $data_barang[] = [
                    'id_barang'=>$item['idBarang'],
                    'id_divisi'=>$item['idDivisi'],
                    'id_group'=>$item['idGrup'],
                    'kode_barang'=>$item['kodeBarang'],
                    'barcode'=>$item['barcode'],
                    'nama_barang'=>$item['namaBarang'],
                    'kode_satuan'=>$item['kodeSatuanKecil'],
                    'id_merk'=>$item['idMerk'],
                    'ukuran'=>$item['ukuran'],
                    'warna'=>$item['warna'],
                    'berat'=>0,
                    'id_supplier'=>$item['idSupplier'],
                    'harga_order'=>$item['hargaOrder'],
                    'harga_beli_terakhir'=>$item['hargaBeliTerakhir'],
                    'hpp_average'=>$item['hppAverage'],
                    'is_ppn'=>$item['isPPn'],
                    'nama_label'=>$item['namaBarangDiLabel'],
                    'margin'=>$item['marginHarga'],
                    'created_by'=>1,
                    'updated_by'=>1
                ];

                if($item['hargaJual'] != null OR $item['hargaJual'] !=0){
                    $data_setting_harga[] =[
                        'id_setting_harga' => $setting->id_setting_harga,
                        'tanggal_mulai_berlaku' =>$setting->tanggal_mulai_berlaku,
                        'id_barang' => $item['idBarang'],
                        'harga_jual' => $item['hargaJual'],
                        'qty_grosir1'=> ($item['jumlahGrosir1']==null)?0:$item['jumlahGrosir1'],
                        'harga_grosir1'=> ($item['hargaGrosir1']==null)?0:$item['hargaGrosir1'],
                        'qty_grosir2'=> ($item['jumlahGrosir2']==null)?0:$item['jumlahGrosir2'],
                        'harga_grosir2'=> ($item['hargaGrosir2']==null)?0:$item['hargaGrosir2'],
                    ];
                }
                
            }
            // dd($data_setting_harga);
            msBarang::insert($data_barang);
            trSettingHargaDetail::insert($data_setting_harga);
            DB::select('
                INSERT INTO tr_setting_harga_detail_lokasi (id_setting_harga_detail,id_lokasi)
                SELECT id_setting_harga_detail,1
                FROM tr_setting_harga_detail
            ');
            DB::commit();
            return response()->json(['success'=>true,'data'=>$data_barang]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
