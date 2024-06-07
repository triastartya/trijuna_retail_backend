<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use App\Repositories\Finance\posKroscekTutupKasirRepository;

class posKroscekTutupKasirController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new posKroscekTutupKasirRepository();
        parent::__construct($this->repository);
    }

    public function kroscek_tutup_kasir(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();;
            $data['id_user_kasir'] = Auth::id();
            $data['status_tutup_kasir'] = 'OPEN';
            $data['tanggal_tutup_kasir'] = Carbon::now()->format('Y-m-d H:i:s');
            unset($data['detail']);
            $tutup_kasir = posTutupKasir::create($data);
            foreach($request->detail as $detail){
                $detail['id_tutup_kasir'] = $tutup_kasir->id_tutup_kasir;
                posTutupKasirDetailPendapatan::create($detail);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$tutup_kasir->id_tutup_kasir]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
