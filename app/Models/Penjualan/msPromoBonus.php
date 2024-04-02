<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPromoBonus extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'ms_promo_bonus';
    protected $fillable = ['id_promo_bonus','kode_promo_bonus','nama_promo_bonus','is_kelipatan','keterangan','tanggal_mulai','tanggal_berakhir','gambar','is_active','created_by','updated_by','is_active'];
    protected $primaryKey = 'id_promo_bonus';
    protected $modelFields = [
        ['name'=>'id_promo_bonus', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'kode_promo_bonus', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'nama_promo_bonus','type'=>ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'is_kelipatan', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name'=>'keterangan','type'=>ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'tanggal_mulai','type'=>ModelDictionary::COLUMN_TYPE_DATE],
        ['name'=>'tanggal_berakhir','type'=>ModelDictionary::COLUMN_TYPE_DATE],
        ['name'=>'gambar','type'=>ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'is_active','type'=>ModelDictionary::COLUMN_TYPE_BOOLEAN]
    ];
    protected $guarded = [];
    protected $appends = [];
    public function rules()
    {
        return [
            'id_promo_bonus'=>'',
            'kode_promo_bonus'=>'required',
            'nama_promo_bonus'=>'required',
            'is_kelipatan'=>'required',
            'keterangan'=>'required',
            'tanggal_mulai'=>'required',
            'tanggal_berakhir'=>'required',
            'gambar'=>'',
            'is_active'=>''
        ];
    }
}