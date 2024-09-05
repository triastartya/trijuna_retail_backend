<?php

namespace App\Http\Controllers\Master;

use App\Helpers\GeneradeNomorHelper;
use App\Helpers\LokasiHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\msBarang;
use App\Models\Master\msBarangKartuStok;
use App\Models\Master\msBarangRak;
use App\Models\Master\msBarangSatuan;
use App\Models\Master\msBarangStok;
use App\Models\Master\msLokasi;
use App\Models\Master\trSettingHarga;
use App\Models\Master\trSettingHargaDetail;
use App\Repositories\Master\barangRepository;
use App\Repositories\Penjualan\penjualanRepository;
use DateTime;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class barangController extends VierController
{
    public $repository;
    public $repository_penjualan;
    public function __construct()
    {
        $this->repository = new barangRepository();
        $this->repository_penjualan =  new penjualanRepository();
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

    public function edit(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            unset($data['id_satuan2']);
            unset($data['isi_satuan2']);
            unset($data['id_satuan3']);
            unset($data['isi_satuan3']);
            $update = msBarang::where('id_barang',$request->id_barang)
            ->update($data);
            $barang = msBarang::where('id_barang',$request->id_barang)->first();
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
            return response()->json(['success'=>true,'data'=>$update]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$ex->getMessage()]);
        }
    }

    public function detail(Request $request){
        try {
            $barang = msBarang::where('id_barang',$request->id_barang)->first();
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

    // public function lihat_kartu_stok(Request $request){
    //     try {
    //         $barang = msBarangKartuStok::where('id_barang',$request->id_barang)
    //         return response()->json(['success'=>true,'data'=>$barang]);
    //     } catch (\Exception $ex) {
    //         return response()->json(['success'=>false,'message'=>$ex->getMessage()]);        }
//    }

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

    public function lihat_stok_omzet(Request $request){
        try {
            $barang = msBarang::with('stok.warehouse')->where('id_barang',$request->id_barang)->first();
            $omzet = $this->repository_penjualan->get_omzet_barang_by_month();
            if($omzet[0]->qty_jual){
                $barang->omzet = (float)$omzet[0]->qty_jual;
            }else{
                $barang->omzet = 0;
            }
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

    public function lihat_omzet(){
        try {
            $data = $this->repository_penjualan->get_mozet_last_3_month(); 
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage()]);
        }
    }

    public function lihat_stok_cabang(Request $request){
        try {
            $data = msLokasi::all();
            foreach($data as $index=>$lokasi){
                try {
                    $response = Http::withOptions(['verify' => false])->get($lokasi->server."/api/barang/lihat_stok/".$request->id_barang);
                    if($response->successful()){
                        $res = $response->object();
                    $data[$index]->jumlah_stok = $res->data->jumlah_stok;
                    $data[$index]->status_stok = true;
                    $data[$index]->stok = $res->data->stok;
                    $data[$index]->message = 'berhasil';
                    }else{
                        $data[$index]->jumlah_stok = 0;
                        $data[$index]->status_stok = false;
                        $data[$index]->stok = [];
                        $data[$index]->message = $response->status().', ';
                    }
                }catch (\Exception $ex) {
                    $data[$index]->jumlah_stok = 0;
                    $data[$index]->status_stok = false;
                    $data[$index]->stok = [];
                    $data[$index]->message = $ex->getMessage();
                }
            }
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'message'=>$ex->getMessage()]);
        }
    }

    public function lihat_stok_omzet_cabang(Request $request){
        try {
            $data = msLokasi::all();
            foreach($data as $index=>$lokasi){
                try {
                    $response = Http::withOptions(['verify' => false])->get($lokasi->server."/api/barang/lihat_stok_omzet/".$request->id_barang);
                    if($response->successful()){
                        $res = $response->object();
                        $data[$index]->jumlah_stok = $res->data->jumlah_stok;
                        $data[$index]->last_omzet = $res->data->omzet;
                        $data[$index]->status_stok = true;
                        $data[$index]->stok = $res->data->stok;
                        $data[$index]->message = 'berhasil';
                    }else{
                        $data[$index]->jumlah_stok = 0;
                        $data[$index]->last_omzet = 0 ;
                        $data[$index]->status_stok = false;
                        $data[$index]->stok = [];
                        $data[$index]->message = $response->status().', err';
                    }
                }catch (\Exception $ex) {
                    $data[$index]->jumlah_stok = 0;
                    $data[$index]->last_omzet = 0 ;
                    $data[$index]->status_stok = false;
                    $data[$index]->stok = [];
                    $data[$index]->message = $ex->getMessage();
                }
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
            ini_set('memory_limit','1000M');
            ini_set('max_execution_time', 0);
            $data = $this->repository->barang_pos();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function import(){
        DB::beginTransaction();
        try {
            ini_set('memory_limit','256M');
            ini_set('max_execution_time', 0);
            $response = File::json(base_path().'/public/data/baru/barang.json');
            // dd($response);
            // msBarang::truncate(); 
            // trSettingHarga::truncate();
            // trSettingHargaDetail::truncate();
            $data_barang = [];
            $data_setting_harga = [];
            $setting= trSettingHarga::create([
                 'id_lokasi' => 1,
                 'tanggal_mulai_berlaku' => new DateTime()
            ]);
            foreach($response as $item){
                $item = (array)$item;
                // dd($item);
                $data_barang[] = [
                    'id_barang'=>$item['IdBarang'],
                    'id_divisi'=>$item['IdDivisi'],
                    'id_group'=>$item['IdGrup'],
                    'kode_barang'=>$item['KodeBarang'],
                    'barcode'=>$item['Barcode'],
                    'nama_barang'=>$item['NamaBarang'],
                    'kode_satuan'=>$item['KodeSatuanKecil'],
                    'id_merk'=>$item['IdMerk'],
                    'ukuran'=>$item['Ukuran'],
                    'warna'=>$item['Warna'],
                    'berat'=>0,
                    'id_supplier'=>$item['IdSupplier'],
                    'harga_order'=>$item['HargaOrder'],
                    'harga_beli_terakhir'=>$item['HargaBeliTerakhir'],
                    'hpp_average'=>$item['HppAverage'],
                    'is_ppn'=>$item['IsPPn'],
                    'nama_label'=>$item['NamaBarangDiLabel'],
                    'margin'=>$item['MarginHarga'],
                    'created_by'=>1,
                    'updated_by'=>1
                ];

                if($item['HargaJual'] != null OR $item['HargaJual'] !=0){
                    $data_setting_harga[] =[
                        'id_setting_harga' => $setting->id_setting_harga,
                        'tanggal_mulai_berlaku' =>$setting->tanggal_mulai_berlaku,
                        'id_barang' => $item['IdBarang'],
                        'harga_jual' => $item['HargaJual'],
                        'qty_grosir1'=> ($item['JumlahGrosir1']==null)?0:$item['JumlahGrosir1'],
                        'harga_grosir1'=> ($item['HargaGrosir1']==null)?0:$item['HargaGrosir1'],
                        'qty_grosir2'=> ($item['JumlahGrosir2']==null)?0:$item['JumlahGrosir2'],
                        'harga_grosir2'=> ($item['HargaGrosir2']==null)?0:$item['HargaGrosir2'],
                    ];
                }
                
            }
            // dd($data_setting_harga);
            msBarang::insert($data_barang);
            trSettingHargaDetail::insert($data_setting_harga);
            // DB::select('
            //     INSERT INTO tr_setting_harga_detail_lokasi (id_setting_harga_detail,id_lokasi)
            //     SELECT id_setting_harga_detail,1
            //     FROM tr_setting_harga_detail
            // ');
            DB::commit();
            return response()->json(['success'=>true,'data'=>$data_barang]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function kartu_stok(){
        try {
            $kartu_stok = DB::select("select mbks.*,mu.nama from ms_barang_kartu_stok mbks
                            inner join users mu on mbks.created_by = mu.id_user
                            where mbks.tanggal between '".request()->start."' and '".request()->end."' and mbks.id_barang = ".request()->id_barang." and mbks.id_warehouse = ".request()->id_warehouse);
            return response()->json(['success'=>true,'data'=>$kartu_stok]);
        } catch(\Exception $err) {
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function history_penerimaan(){
        try {
            $data = DB::select("
                select tpd.qty,tpd.qty_bonus,tpd.harga_order as harga_beli,tp.tanggal_nota,ms.nama_supplier
                from tr_penerimaan tp inner join tr_penerimaan_detail tpd on tp.id_penerimaan=tpd.id_penerimaan
                inner join ms_supplier ms on tp.id_supplier=ms.id_supplier
                where id_barang = ".request()->id_barang."
                order by tanggal_nota desc limit 5
            ");
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $err) {
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
