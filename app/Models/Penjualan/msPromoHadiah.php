<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPromoHadiah extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'ms_promo_hadiah';
    protected $fillable = ['id_promo_hadiah','is_kelipatan','kode_promo_hadiah','nama_promo_hadiah','nilai_promo_hadiah','keterangan','kuota','jumlah','hadiah','tanggal_mulai','tanggal_berakhir','gambar','is_active'];
    protected $primaryKey = 'id_promo_hadiah';
    protected $modelFields = [
        ['name'=>'id_promo_hadiah', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'is_kelipatan', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name'=>'kode_promo_hadiah', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'nama_promo_hadiah','type'=>ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'nilai_promo_hadiah','type'=>ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'keterangan','type'=>ModelDictionary::COLUMN_TYPE_STRING],
        ['name'=>'jumlah','type'=>ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'hadiah','type'=>ModelDictionary::COLUMN_TYPE_INTEGER],
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
            'id_promo_hadiah'=>'',
            'is_kelipatan'=>'required',
            'kode_promo_hadiah'=>'required',
            'nama_promo_hadiah'=>'required',
            'nilai_promo_hadiah'=>'required',
            'keterangan'=>'required',
            'jumlah'=>'required',
            'hadiah'=>'required',
            'tanggal_mulai'=>'required',
            'tanggal_berakhir'=>'required',
            'gambar'=>'',
            'is_active'=>''
        ];
    }
}
