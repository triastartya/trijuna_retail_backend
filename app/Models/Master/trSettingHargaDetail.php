<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingHargaDetail extends Model
{
    use HasFactory,VierModel;
    protected $table = 'tr_setting_harga_detail';
    protected $fillable = [
        'id_setting_harga_detail',
        'tanggal_mulai_berlaku',
        'id_setting_harga',
        'id_barang',
        'harga_jual',
        'qty_grosir1',
        'harga_grosir1',
        'qty_grosir2',
        'harga_grosir2',
        'priority',
    ];
    protected $primaryKey = 'id_setting_harga_detail';
    protected $modelFields = [
        ['name' => 'id_setting_harga_detail', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'tanggal_mulai_berlaku', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_setting_harga', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'harga_jual', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'qty_grosir1', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'harga_grosir1', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'qty_grosir2', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'harga_grosir2', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'priority', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_setting_harga_detail'=>'',
            'id_setting_harga'=>'required',
            'tanggal_mulai_berlaku'=>'required',
            'id_barang'=>'required',
            'harga_jual'=>'required',
            'qty_grosir1'=>'required',
            'harga_grosir1'=>'required',
            'qty_grosir2'=>'required',
            'harga_grosir2'=>'required',
            'priority'=>''
        ];
    }
}
