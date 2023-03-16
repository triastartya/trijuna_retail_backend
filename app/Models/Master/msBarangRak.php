<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msBarangRak extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_barang_rak';
    protected $fillable = [
        'id_barang',
        'id_rak'
    ];
    protected $primaryKey = 'id_barang_rak';
    protected $modelFields = [
        ['name' => 'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_rak', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
        'id_barang_rak'=>'',
        'id_barang'=>'required',
        'id_rak'=>'required',
        'created_by'=>'',
        'updated_by'=>''
        ];
    }
}
