<?php

namespace App\Http\Controllers\Pembelian;

use App\Helpers\GeneradeNomorHelper;
use App\Models\Pembelian\trPemesanan;
use App\Models\Pembelian\trPemesananDetail;
use App\Models\Pembelian\trPenerimaan;
use App\Models\Pembelian\trPenerimaanDetail;
use App\Repositories\Pembelian\penerimaanDenganPORepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class penerimaanDenganPOController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new penerimaanDenganPORepository();
        parent::__construct($this->repository);
    }
    
    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_penerimaan'] = 'OPEN';
            $data['nomor_penerimaan'] = GeneradeNomorHelper::long('penerimaan');
            unset($data['detail']);
            $penerimaan = trPenerimaan::create($data);
            $pemesanan = trPemesanan::where('id_pemesanan',$data['id_pemesanan'])
                            ->update([
                                'status_pemesanan' => 'DITERIMA'
                            ]);
            foreach($request->detail as $detail){
                $detail['id_pemesanan'] = $penerimaan->id_penerimaan;
                unset($data['id_pemesanan_detail']);
                trPenerimaanDetail::create($detail);
                $pemesananDetail = trPemesananDetail::where('id_pemesanan_detail',$detail['id_pemesanan_detail'])->first();
                $pemesananDetail->qty_terima = $pemesananDetail->qty_terima - $data['qty'];
                $pemesananDetail->save();
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$penerimaan->id_penerimaan]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
