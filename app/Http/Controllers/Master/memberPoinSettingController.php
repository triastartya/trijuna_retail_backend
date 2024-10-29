<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msMemberPoinSetting;
use App\Models\Master\msMemberPoinSettingGroup;
use App\Repositories\Master\memberPoinSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class memberPoinSettingController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new memberPoinSettingRepository();
        parent::__construct($this->repository);
    }

    public function insert(Request $request){
        DB::beginTransaction();
        try {
            $settingPoint = msMemberPoinSetting::where('id_member_poin_setting',1)->first();
            if(!$settingPoint){
                $settingPoint = new msMemberPoinSetting();
            }
            $settingPoint->nominal = $request->nominal;
            $settingPoint->dapat_poin = $request->dapat_poin;
            $settingPoint->save();
            msMemberPoinSettingGroup::truncate();
            foreach($request->group as $detail){
                msMemberPoinSettingGroup::create([
                    'id_member_poin_setting' =>1,
                    'id_group'=>$detail['id_group']
                ]);
            }
            DB::commit();
            return response()->json(['success'=>true,'data'=>$settingPoint]);
        }
        catch(\Exception $err) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }

    public function get(){
        $data = msMemberPoinSetting::where('id_member_poin_setting',1)->first();
        // dd($data);
        $detail = DB::select('SELECT mmpsg.id_member_poin_setting_group,mg.id_group,mg."group" from ms_member_poin_setting_group mmpsg inner join  ms_group mg on mmpsg.id_group=mg.id_group',[]);
        $data->group = $detail;
        return response()->json(['success'=>true,'data'=>$data]);
    }
}
