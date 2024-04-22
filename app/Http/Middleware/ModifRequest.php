<?php

namespace App\Http\Middleware;

use App\Helpers\GeneradeNomorHelper;
use App\Models\nomorCounter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ModifRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->method()=="POST" & $this->parse($request)=="member"){
            $request->merge([
                'kode_member'=>GeneradeNomorHelper::long('member'),
                'password'=>bcrypt($request->password)
            ]);
        }
        
        if($request->method()=="POST" & $this->parse($request)=="supplier"){
            $request->merge([
                'kode_supplier'=>GeneradeNomorHelper::long('supplier'),
                'sisa_hutang' =>0
            ]);
        }
        
        if($request->method()=="POST" & $this->parse($request)=="divisi"){
            $request->merge([
                'kode_divisi'=>GeneradeNomorHelper::sort('divisi'),
            ]);
        }
        
        if($request->method()=="POST" & $this->parse($request)=="group"){
            $request->merge([
                'kode_group'=>$this->GeneradeNomorSort('group'),
            ]);
        }
        
        if($request->method()=="POST" & $this->parse($request)=="merk"){
            $request->merge([
                'kode_merk'=>$this->GeneradeNomorSort('merk'),
            ]);
        }
        
        if($request->method()=="POST" & $this->parse($request)=="rak"){
            $request->merge([
                'kode_rak'=>$this->GeneradeNomorSort('rak'),
            ]);
        }
        
        if($request->method()=="POST" & $this->parse($request)=="lokasi"){
            $request->merge([
                'kode_lokasi'=>$this->GeneradeNomorSort('lokasi'),
            ]);
        }

        if($request->method()=="POST" & $this->parse($request)=="ms_promo_diskon"){
            $request->merge([
                'kode_promo_diskon'=>$this->GeneradeNomorSort('promo diskon'),
            ]);
        }

        if($request->method()=="POST" & $this->parse($request)=="ms_promo_hadiah"){
            $request->merge([
                'kode_promo_hadiah'=>$this->GeneradeNomorSort('promo hadiah'),
            ]);
        }
        
        return $next($request);
    }
    
    public function parse($request){
        $url = explode("/",$request->url());
        return end($url);
    }
    
    public function GeneradeNomorSort($keterangan){
        $master_counter_forupdate = nomorCounter::where('keterangan',$keterangan)->lockForUpdate()->first();
        $master_counter_forupdate->counter = $master_counter_forupdate->counter + 1;
        $master_counter_forupdate->save();
        return sprintf('%04s', $master_counter_forupdate->counter);
    }
    
}
