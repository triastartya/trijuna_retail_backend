<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\posKroscekTutupKasir;
use App\Models\Finance\posKroscekTutupKasirDetailPendapatan;
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
        // Get Data Tutupan Kasir
        // Get Data Detail Pendapatan Tutupan Kasir
        // insert kroscek tutup kasir
        // insert detail kroscek tutup kasir
        // update tutup kasir
        // - status jadi validate
        // - id kroscek tutup kasir
        DB::beginTransaction();
        try {
            // Get Data Tutupan Kasir
            $tutup_kasir = posTutupKasir::where('id_tutup_kasir',$request->id_tutup_kasir)->first();
            if(!$tutup_kasir){
                throw new \Exception('data tutup kasir tidak di temukan');
            }
            // Get Data Detail Pendapatan Tutupan Kasir
            $tutup_kasir_detail = posTutupKasirDetailPendapatan::where('id_tutup_kasir',$request->id_tutup_kasir)->first();
            $versi_sistem = 0;
            $versi_kasir = 0;
            foreach ($tutup_kasir_detail as $item){
                $versi_sistem += $item->nominal_sistem;
                $versi_kasir += $item->nominal;
            }
            // insert kroscek tutup kasir
            $kroscek_tutup_kasir = posKroscekTutupKasir::create([
                'id_tutup_kasir' => $request->id_tutup_kasir,
                'tanggal_kroscek_tutup_kasir' => $request->tanggal_kroscek_tutup_kasir,
                'keterangan' => $request->keterangan,
                'pendapatan_versi_user' => $versi_kasir,
                'pendapatan_versi_system' => $versi_sistem,
                'selisih' => $versi_sistem - $versi_kasir
            ]);
            // insert detail kroscek tutup kasir
            foreach ($tutup_kasir_detail as $detail) {
                posKroscekTutupKasirDetailPendapatan::create([
                    'id_kroscek_tutup_kasir' => $kroscek_tutup_kasir->id_kroscek_tutup_kasir,
                    'id_payment_method' => $detail['id_payment_method'],
                    'payment_method' => $detail['payment_method'],
                    'nominal' => $detail['nominal']
                ]);
            }
            // update tutup kasir
            // - status jadi validate
            // - id kroscek tutup kasir 
            posTutupKasir::where('id_tutup_kasir',$request->id_tutup_kasir)
            ->update([
                'id_kroscek_tutup_kasir' => $kroscek_tutup_kasir->id_kroscek_tutup_kasir,
                'status_tutup_kasir' => 'VALIDATED'
            ]);
            DB::commit();
            return response()->json(['success'=>true,'data'=>$kroscek_tutup_kasir]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function by_param(){
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }

    public function by_id(){
        try{
            $data = $this->repository->by_id();
            $data->detail_pendapatan = $this->repository->detail_by_id();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }
}
