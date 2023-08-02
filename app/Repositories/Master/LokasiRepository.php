<?php

namespace App\Repositories\Master;

use App\Models\Master\msLokasi;
use Illuminate\Support\Facades\Http;
use Viershaka\Vier\VierRepository;

class LokasiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msLokasi());
    }
    
    public function get_lokasi_status_online(){
        $data = $this->model->all();
        foreach( $data as $key =>$value ){
            $status_online = false;
            try{
                $response = Http::get($value->server.'/api/health');
                if($response->ok()){
                    $status_online = true;
                }
            }catch(\Exception $ex){
                $status_online = false;
            }            
            $value->status_online = $status_online;
            $data[$key] = $value;
        }
        return $data;
    }
}
