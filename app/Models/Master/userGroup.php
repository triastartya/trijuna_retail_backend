<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class userGroup extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'user_groups';
    protected $fillable = ['group_name'];
    protected $primaryKey = 'id_group';
    protected $modelFields = [
        ['name' => 'id_group', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'group_name', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_group'=>'',
            'group_name'=>'required',
            'is_active'=>'',
        ];
    }
}