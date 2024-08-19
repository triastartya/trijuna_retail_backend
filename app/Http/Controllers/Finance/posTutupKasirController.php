<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\posModalKasir;
use Viershaka\Vier\VierController;
use App\Repositories\Finance\posTutupKasirRepository;
use Illuminate\Http\Request;
use App\Models\Finance\posTutupKasir;
use App\Models\Finance\posTutupKasirDetailPendapatan;
use App\Models\Penjualan\posPenjualan;
use App\Models\Penjualan\posPenjualanDetail;
use App\Models\Penjualan\posPenjualanPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use function Laravel\Prompts\select;

class posTutupKasirController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new posTutupKasirRepository();
        parent::__construct($this->repository);
    }

    public function tutup_kasir(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_tutup_kasir'] = 'OPEN';
            $data['tanggal_tutup_kasir'] = Carbon::now()->format('Y-m-d H:i:s');
            unset($data['detail']);
            $tutup_kasir = posTutupKasir::create($data);
            foreach($request->detail as $detail){
                $detail['id_tutup_kasir'] = $tutup_kasir->id_tutup_kasir;
                $nominal_sistem = $this->repository->nominal_sistem($detail['id_payment_method']);
                $detail['nominal_sistem'] = $nominal_sistem;
                $detail['selisih'] = $nominal_sistem - $detail['nominal'];
                posTutupKasirDetailPendapatan::create($detail);
            }
            //update modal kasir;
            posModalKasir::where('id_user_kasir',$data['id_user_kasir'])
                ->whereNull('id_tutup_kasir')
                ->update([
                    'id_tutup_kasir'=>$tutup_kasir->id_tutup_kasir
                ]);
            //update penjualan;
            posPenjualan::where('id_user_kasir',$data['id_user_kasir'])
            ->whereNull('id_tutup_kasir')
            ->update([
                'id_tutup_kasir'=>$tutup_kasir->id_tutup_kasir
            ]);
            DB::commit();
            return response()->json(['success'=>true,'data'=>$tutup_kasir->id_tutup_kasir]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function kasir_belum_closing()
    {
        try{
            $data = $this->repository->kasir_belum_closing();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }

    public function history()
    {
        try{
            $data = $this->repository->history();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }
}
