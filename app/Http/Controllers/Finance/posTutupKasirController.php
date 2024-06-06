<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Viershaka\Vier\VierController;
use App\Repositories\Finance\posTutupKasirRepository;
use Illuminate\Http\Request;
use App\Models\Finance\posTutupKasir;
use App\Models\Finance\posTutupKasirDetailPendapatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
