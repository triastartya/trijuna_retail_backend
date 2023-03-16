<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msGroup extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_group';
    protected $fillable = ['kode_group','group'];
    protected $primaryKey = 'id_group';
    protected $modelFields = [
        ['name' => 'id_group', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'kode_group', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'group', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_group'=>'',
            'kode_group'=>'required',
            'group'=>'required',
            'is_active'=>'',
        ];
    }
}
