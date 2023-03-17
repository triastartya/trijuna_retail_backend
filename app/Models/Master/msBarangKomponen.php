<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msBarangKomponen extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_barang_komponen';
    protected $fillable = [
        'id_barang',
        'qty_komponen'
    ];
    protected $primaryKey = 'id_barang_komponen';
    protected $modelFields = [
        ['name' => 'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'qty_komponen', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
        'id_barang_komponen'=>'',
        'id_barang'=>'required',
        'qty_komponen'=>'required',
        'created_by'=>'',
        'updated_by'=>''
        ];
    }
}
