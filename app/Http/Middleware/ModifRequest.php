<?php

namespace App\Http\Middleware;

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
        
        return $next($request);
    }
    
    public function parse($request){
        $url = explode("/",$request->url());
        return end($url);
    }
    
}
