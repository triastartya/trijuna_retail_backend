<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\posModalKasir;
use Viershaka\Vier\VierController;
use App\Repositories\Finance\posTutupKasirRepository;
use Illuminate\Http\Request;
use App\Models\Finance\posTutupKasir;
use App\Models\Finance\posTutupKasirDetailPendapatan;
use App\Models\Finance\posTutupKasirDetailPendapatanCash;
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
        // insert data tutup kasir
        // get nominal sistem
        // jika cash get kembalian sistem
        // jika cash get nominal sistem di kurangi kembalian
        // hitung selisih
        // insert detail pendapatan tutup kasir
        // jika cash insert detail pendapatan cash
        // update id_tutup_kasir di modal kasir
        // update id_tutup_kasir di pos penjualan
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status_tutup_kasir'] = 'OPEN';
            $data['tanggal_tutup_kasir'] = Carbon::now()->format('Y-m-d H:i:s');
            unset($data['detail']);
            // insert data tutup kasir
            $tutup_kasir = posTutupKasir::create($data);
            foreach($request->detail as $detail){
                $detail['id_tutup_kasir'] = $tutup_kasir->id_tutup_kasir;
                // get nominal sistem
                $nominal_sistem = $this->repository->nominal_sistem($detail['id_payment_method']);
                $kembalian_sistem = 0;
                if($detail['id_payment_method']==1){
                    // jika cash get kembalian sistem
                    $kembalian_sistem = $this->repository->kembalian_sistem();
                    // jika cash get nominal sistem di kurangi kembalian
                    $nominal_sistem = $nominal_sistem - $kembalian_sistem;
                }
                $detail['nominal_sistem'] = $nominal_sistem;
                // hitung selisih 
                $detail['selisih'] = $nominal_sistem - $detail['nominal'];
                // insert detail pendapatan tutup kasir
                $detail_pendapatan = posTutupKasirDetailPendapatan::create($detail);
                if($detail['id_payment_method']==1){
                    // jika cash insert detail pendapatan cash
                    posTutupKasirDetailPendapatanCash::create([
                        'id_tutup_kasir_detail_pendapatan' => $detail_pendapatan->id_tutup_kasir_detail_pendapatan,
                        'bayar' => $kembalian_sistem + $nominal_sistem,
                        'kembalian' =>$kembalian_sistem,
                        'nominal' => $nominal_sistem,
                    ]);
                }
            }
            //update id_tutup_kasir di modal kasir ;
            posModalKasir::where('id_user_kasir',$data['id_user_kasir'])
                ->whereNull('id_tutup_kasir')
                ->update([
                    'id_tutup_kasir'=>$tutup_kasir->id_tutup_kasir
                ]);
            //update id_tutup_kasir di pos penjualan;
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

    public function detail_tutup_kasir()
    {
        try{
            $data = $this->repository->get_by_id();
            $data->pendapatan = $this->repository->get_detail_penerimaan();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }
}
