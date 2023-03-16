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
                'kode_member'=>'12345',
                'password'=>bcrypt($request->password)
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
