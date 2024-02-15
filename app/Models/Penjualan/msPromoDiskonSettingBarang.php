<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPromoDiskonSettingBarang extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    protected $table = 'ms_promo_diskon_setting_barang';
    protected $fillable = ['id_promo_diskon_setting_barang','id_promo_diskon','id_barang'];
    protected $primaryKey = 'id_promo_diskon_setting_barang';
    protected $modelFields = [
        ['name'=>'id_promo_diskon_setting_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_promo_diskon', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_barang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_promo_diskon_setting_barang'=>'',
            'id_promo_diskon'=>'required',
            'id_barang'=>'required'
        ];
    }
}
