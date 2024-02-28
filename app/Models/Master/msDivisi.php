<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msDivisi extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'ms_divisi';
    protected $fillable = [
        'id_divisi',
        'kode_divisi',
        'divisi',
        'is_active'
    ];
    protected $primaryKey = 'id_divisi';
    protected $modelFields = [
        ['name' => 'kode_divisi', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'divisi', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_divisi'=>'',
            'kode_divisi'=>'required',
            'divisi'=>'required',
            'is_active'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
