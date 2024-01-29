<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPromoDiskon extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'ms_promo_diskon';
    protected $fillable = ['id_promo_diskon','is_nominal','kode_promo_diskon','nama_promo_diskon','minimal_qty','diskon','kuota','tanggal_mulai','tanggal_berakhir','gambar','is_active'];
    protected $primaryKey = 'id_promo_diskon';
    protected $modelFields = [
        ['name'=>'id_promo_diskon', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'is_nominal', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name'=>'kode_promo_diskon', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'nama_promo_diskon','type'=>ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'minimal_qty','type'=>ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'diskon','type'=>ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'kuota','type'=>ModelDictionary::COLUMN_TYPE_INTEGER],
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
            'id_promo_diskon'=>'',
            'is_nominal'=>'required',
            'kode_promo_diskon'=>'required',
            'nama_promo_diskon'=>'required',
            'minimal_qty'=>'required',
            'diskon'=>'required',
            'kuota'=>'required',
            'tanggal_mulai'=>'required',
            'tanggal_berakhir'=>'required',
            'gambar'=>'',
            'is_active'=>''
        ];
    }
}
