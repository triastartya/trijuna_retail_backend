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
}
