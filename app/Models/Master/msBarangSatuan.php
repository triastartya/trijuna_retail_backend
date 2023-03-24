<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msBarangSatuan extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'ms_barang_satuan';
    protected $fillable = [
        'id_barang',
        'id_satuan',
        'isi'
    ];
    protected $primaryKey = 'id_brang_satuan';
    protected $modelFields = [
        ['name' => 'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_rak', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'isi', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
        'id_brang_satuan'=>'',
        'id_barang'=>'required',
        'id_satuan'=>'required',
        'isi' => 'required',
        'created_by'=>'',
        'updated_by'=>''
        ];
    }
}
