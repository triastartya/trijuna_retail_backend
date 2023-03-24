<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class trSettingHarga extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    protected $table = 'tr_setting_harga';
    protected $fillable = [
        'id_setting_harga',
        'id_lokasi',
        'tanggal_mulai_berlaku',
        'created_by',
        'updated_by'
    ];
    protected $primaryKey = 'id_setting_harga';
    protected $modelFields = [
        ['name' => 'id_setting_harga', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_lokasi', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'tanggal_mulai_berlaku', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'created_by', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'updated_by', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_setting_harga'=>'',
            'id_lokasi'=>'required',
            'tanggal_mulai_berlaku'=>'required',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
