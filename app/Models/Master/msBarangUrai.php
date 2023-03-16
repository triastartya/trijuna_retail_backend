<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msBarangUrai extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_barang_urai';
    protected $fillable = [
        'id_barang',
        'qty_urai'
    ];
    protected $primaryKey = 'id_barang_urai';
    protected $modelFields = [
        ['name' => 'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_barang_urai', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'qty_urai', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
        'id_barang_urai'=>'',
        'id_barang'=>'required',
        'qty_urai'=>'required',
        'created_by'=>'',
        'updated_by'=>''
        ];
    }
}
