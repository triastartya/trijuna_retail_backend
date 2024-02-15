<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPromoHadiahSettingMerk extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    protected $table = 'ms_promo_hadiah_setting_merk';
    protected $fillable = ['id_promo_hadiah_setting_merk','id_promo_hadiah','id_merk'];
    protected $primaryKey = 'id_promo_hadiah_setting_merk';
    protected $modelFields = [
        ['name'=>'id_promo_hadiah_setting_merk', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_promo_hadiah', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_merk', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_promo_diskon_setting_merk'=>'required',
            'id_promo_hadiah'=>'required',
            'id_merk'=>'required'
        ];
    }
}
