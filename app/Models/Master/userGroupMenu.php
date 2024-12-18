<?php

namespace App\Models\Master;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Viershaka\Vier\VierModel;

class userGroupMenu extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'users_group_menus';
    protected $fillable = ['id_group','id_menu'];
    protected $primaryKey = 'id_user_group';
    protected $modelFields = [
        ['name' => 'id_user_group', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_group', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_menu', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
    ];
    protected $guarded = [];
    protected $appends = [];
    public function rules()
    {
        return [
            'id_user_group'=>'',
            'id_group'=>'required',
            'id_menu'=>'required',
        ];
    }
}