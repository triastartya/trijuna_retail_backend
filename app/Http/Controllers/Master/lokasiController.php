<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msLokasi;
use App\Repositories\Master\LokasiRepository;
use Illuminate\Support\Facades\Http;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class lokasiController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new LokasiRepository();

        parent::__construct($this->repository);
    }

    public function all_status_online(){
        try{
            $data = msLokasi::all();
            foreach($data as $key=>$item){
                try {
                $online = Http::withOptions(['verify' => false])->get($item->server."/api/health");
                if($online->successful()){
                    $data[$key]->nama_lokasi = $data[$key]->nama_lokasi .'- ONLINE';
                }else{
                    $data[$key]->nama_lokasi = $data[$key]->nama_lokasi .'- OFFLINE';
                }
                }catch (\Exception $ex) {
                    $data[$key]->nama_lokasi = $data[$key]->nama_lokasi .'- OFFLINE';
                }
            }
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
