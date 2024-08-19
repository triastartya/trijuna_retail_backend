<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\posTutupKasir;
use App\Models\Finance\posTutupKasirDetailPendapatan;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use App\Repositories\Finance\posKroscekTutupKasirRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class posKroscekTutupKasirController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new posKroscekTutupKasirRepository();
        parent::__construct($this->repository);
    }

    public function tutup_kasir_belum_croscek(){
        try{
            $data = $this->repository->tutup_kasir_belum_kroscek();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }

    public function tutup_kasir_by_id(){
        try{
            $data = $this->repository->tutup_kasir_belum_kroscek();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }

    public function kroscek_tutup_kasir(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();;
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
