<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Viershaka\Vier\VierController;
use App\Models\Finance\posModalKasir;
use App\Repositories\Finance\kasirRepository;
use Illuminate\Http\Request;

class kasirController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new kasirRepository();
        parent::__construct($this->repository);
    }

    public function get_modal_kasir($id_user_kasir)
    {
        try{
            $data = posModalKasir::whereNull('id_tutup_kasir')
            ->where('id_user_kasir', $id_user_kasir)
            ->get();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {  
            Log::error('Error in get_modal_kasir: ' . $ex->getMessage());
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage(), 'code' => $ex->getCode()]);
        }
    }
}