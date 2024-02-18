<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPromoHadiahSettingBarang extends Model
{
    use HasFactory,VierModel;
    protected $table = 'ms_promo_hadiah_setting_barang';
    protected $fillable = ['id_promo_hadiah_setting_barang','id_promo_hadiah','id_barang'];
    protected $primaryKey = 'id_promo_hadiah_setting_barang';
    protected $modelFields = [
        ['name'=>'id_promo_hadiah_setting_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_promo_hadiah', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_promo_hadiah_setting_barang'=>'',
            'id_promo_hadiah'=>'required',
            'id_barang'=>'required'
        ];
    }
}
