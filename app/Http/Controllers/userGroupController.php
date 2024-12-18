<?php

namespace App\Http\Controllers;

use App\Models\Master\userGroupMenu;
use App\Repositories\Master\userGroupRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userGroupController extends VierController
{
    public function __construct()
    {
        $repository = new userGroupRepository();

        parent::__construct($repository);
    }
    public function get_menu_by_id_user_group(){
        $menus = DB::select("select * from ms_menu",[]);
        foreach($menus as $key => $menu){
            $user_group_menu = userGroupMenu::where('id_group',request()->id_group)->where('id_menu',$menu->id_menu)->first();
            $menus[$key]->assign = ($user_group_menu)?true:false;
        }
        return response()->json(['success'=>true,'data'=>$menus]);
    }
    public function user_group_menu_update(){
        $user_group_menu = userGroupMenu::where('id_group',request()->id_group)->where('id_menu',request()->id_menu)->first();
        if($user_group_menu){
            $delete = userGroupMenu::where('id_group',request()->id_group)->where('id_menu',request()->id_menu)->delete();
        }else{
            $insert = userGroupMenu::create([
                'id_group'=>request()->id_group,
                'id_menu'=>request()->id_menu
            ]);
        } 
        return response()->json(['success'=>true,'data'=>true]);
    }
}
