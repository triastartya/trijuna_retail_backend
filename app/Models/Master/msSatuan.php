<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msSatuan extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_satuan';
    protected $fillable = [
        'kode_satuan',
        'nama_satuan',
        'is_active'
    ];
    protected $primaryKey = 'id_satuan';
    protected $modelFields = [
        ['name' => 'kode_satuan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_satuan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_satuan'=>'',
            'kode_satuan'=>'required',
            'nama_satuan'=>'required',
            'is_active'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
