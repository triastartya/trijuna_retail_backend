<?php

namespace App\Http\Controllers;

use App\Models\Master\msLokasi;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userController extends VierController
{
    public function __construct()
    {
        // $repository = new SchemeRepository();
        // $service = new SchemeService();

        // parent::__construct($repository, $service);
    }
    
    public function register(){
        try{
            $data = request()->all();
            $data['is_active'] = 1 ;
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            auth('web')->login($user);
            request()->session()->regenerate();
            $lokasi = msLokasi::where('is_use',true)->first();
            $hasil =  array_merge($user->toArray(), [
                'token' => $user->createToken(config('app.name'))->plainTextToken,
                'lokasi' => $lokasi
            ]);
            
            //==================
            
            return response()->json(['success'=>true,'data'=>$hasil]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
    
    public function login(){
        $validated = _validate(request()->all(), ['email' => 'required','password'=>'required']);
        try {
            $user = User::where('email', $validated['email'])->first();
            if (!$user || !Hash::check($validated['password'], $user->password)){
                throw new ('email and password not mach.');
            }
            if (!$user->is_active){
                throw new ('User is not active.');
            }
            auth('web')->login($user);
            request()->session()->regenerate();
            $lokasi = msLokasi::where('is_use',true)->first();
            $hasil =  array_merge($user->toArray(), [
                'token' => $user->createToken(config('app.name'))->plainTextToken,
                'version' => '_development',
                'lokasi' => $lokasi
            ]);
            return response()->json(['success'=>true,'data'=>$hasil]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }
}
