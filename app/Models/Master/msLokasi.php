<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\CreatedUpdatedBy;

class msLokasi extends Model
{
    use HasFactory,AttModel;
    
    protected $table = 'ms_lokasi';
    protected $fillable = [
        'id_lokasi',
        'kode_lokasi',
        'nama_lokasi',
        'alamat',
        'telepon',
        'npwp',
        'server',
        'is_use',
        'is_active'
    ];
    protected $primaryKey = 'id_lokasi';
    protected $modelFields = [
        ['name' => 'kode_lokasi', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_lokasi', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'alamat', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'telepon', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'npwp', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'server', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_use', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_lokasi'=>'',
            'kode_lokasi'=>'required',
            'nama_lokasi'=>'required',
            'alamat'=>'required',
            'telepon'=>'required',
            'npwp'=>'required',
            'server'=>'required',
            'is_use'=>'required',
            'is_active'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
