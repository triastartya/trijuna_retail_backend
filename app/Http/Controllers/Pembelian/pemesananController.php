<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Http\Controllers\Controller;
use App\Models\Pembelian\trPemesanan;
use App\Models\Pembelian\trPemesananDetail;
use Att\Workit\AttController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pemesananController extends AttController
{
    public function __construct()
    {
        // $repository = new SchemeRepository();
        // $service = new SchemeService();

        // parent::__construct($repository, $service);
    }
    
    public function simpan(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_pemesanan'] = 'OPEN';
            $data['nomor_pesanan'] = GeneradeNomorHelper::long('pemesanan');
            unlink($data['detail']);
            $pemesanan = trPemesanan::create($data);
            foreach($request->detail as $detail){
                $detail->id_pemesanan = $pemesanan->id_pemesanan;
                trPemesananDetail::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$pemesanan->id_pemesanan]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
    
    public function get_by_id(Request $request){
        try{
            $data = trPemesanan::select("
                select
                tp.id_pemesanan,
                tp.id_supplier,
                ms.kode_supplier,
                ms.nama_supplier,
                ms.alamat,
                tp.nomor_pemesanan,
                tp.tanggal_pemesanan,
                tp.tangal_expired_pemesanan,
                tp.tanggal_kirim,
                tp.id_lokasi,
                ml.nama_lokasi,
                tp.id_warehouse,
                mw.warehouse,
                tp.keterangan,
                tp.status_pemesanan,
                tp.qty,
                tp.sub_total1,
                tp.diskon_persen,
                tp.diskon_nominal,
                tp.sub_total2,
                tp.ppn_nominal,
                tp.total_transaksi,
                tp.created_at,
                uc.nama as created_by,
                tp.updated_by,
                uu.nama as updated_by
                from tr_pemesanan tp
                inner join ms_lokasi ml on tp.id_lokasi = ml.id_lokasi
                inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
                inner join ms_supplier ms on tp.id_supplier = ms.id_supplier
                inner join users uc on uc.id_user = tp.created_by
                inner join users uu on uu.id_user = tp.updated_by
                inner join users ud on ud.id_user = tp.user_deleted
                where tp.id_pemesanan = ?
            ",[$request->id]);
            return response()->json(['status'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            return response()->json(['status'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

}
