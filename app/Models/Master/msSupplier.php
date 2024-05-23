<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msSupplier extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    protected $table = 'ms_supplier';
    protected $fillable = [
    'kode_supplier',
    'nama_supplier',
    'alamat',
    'kota',
    'kecamatan',
    'kelurahan',
    'keterangan',
    'is_pkp',
    'is_tanpa_po',
    'limit_hutang',
    'no_handphone',
    'email',
    'sisa_hutang',
    'is_active',
    ];
    protected $primaryKey = 'id_supplier';
    protected $modelFields = [
        ['name' => 'id_supplier', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'kode_supplier', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_supplier', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'alamat', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'kota', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'kecamatan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'kelurahan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'keterangan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_pkp', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name' => 'is_tanpa_po', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name' => 'limit_hutang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'no_handphone', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'email', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'sisa_hutang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_supplier'=>'',
            'kode_supplier'=>'required',
            'nama_supplier'=>'required',
            'alamat'=>'required',
            'kota'=>'required',
            'kecamatan'=>'required',
            'kelurahan'=>'required',
            'keterangan'=>'',
            'is_pkp'=>'required',
            'is_tanpa_po'=>'required',
            'limit_hutang'=>'',
            'no_handphone'=>'required',
            'email'=>'required',
            'sisa_hutang'=>'',
            'is_active'=>'',
            'created_by'=>'',
            'updated_by'=>'',
        ];
    }
}
