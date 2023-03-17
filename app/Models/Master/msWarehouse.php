<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msWarehouse extends Model
{   
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_warehouse';
    protected $fillable = [
        'warehouse',
        'lokasi',
        'is_active'
    ];
    protected $primaryKey = 'id_warehouse';
    protected $modelFields = [
        ['name' => 'warehouse', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'lokasi', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_warehouse'=>'',
            'warehouse'=>'required',
            'lokasi'=>'required',
            'is_active'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
