<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPromoBonusSettingSupplier extends Model
{
    use HasFactory,VierModel;
    protected $table = 'ms_promo_bonus_setting_supplier';
    protected $fillable = ['id_promo_bonus_setting_supplier','id_promo_bonus','id_supplier'];
    protected $primaryKey = 'id_promo_bonus_setting_supplier';
    protected $modelFields = [
        ['name'=>'id_promo_bonus_setting_supplier', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_promo_bonus', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_supplier', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_promo_bonus_setting_supplier'=>'',
            'id_promo_bonus'=>'required',
            'id_supplier'=>'required'
        ];
    }
}
