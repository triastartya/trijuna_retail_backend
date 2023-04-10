<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msBarangStok extends Model
{
    use HasFactory,VierModel;
    protected $table = 'ms_barang_stok';
    protected $fillable = [
        'id_barang_stok',
        'id_barang',
        'id_warehouse',
        'qty',
        'stok_min',
        'stok_max',
        'created_by',
        'updated_by'
    ];
    protected $primaryKey = 'id_barang_stok';
    protected $modelFields = [
        ['name' => 'id_barang_stok', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_warehouse', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'qty', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'stok_min', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'stok_max', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'created_by', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'updated_by', 'type' => ModelDictionary::COLUMN_TYPE_STRING]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
        'id_barang_stok'=>'',
        'id_barang'=>'required',
        'id_warehouse'=>'required',
        'qty'=>'required',
        'stok_min'=>'',
        'stok_max'=>'',
        'created_by'=>'',
        'updated_by'=>''
        ];
    }
}
