<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msRak extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_rak';
    protected $fillable = [
        'kode_rak',
        'nama_rak',
        'is_active'
    ];
    protected $primaryKey = 'id_rak';
    protected $modelFields = [
        ['name' => 'kode_rak', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_rak', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_rak'=>'',
            'kode_rak'=>'required',
            'nama_rak'=>'required',
            'is_active'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
