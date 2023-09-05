<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class posEdc extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'pos_edc';
    protected $fillable = ['kode_edc','nama_edc','keterangan','is_active'];
    protected $primaryKey = 'id_edc';
    protected $modelFields = [
        ['name' => 'kode_edc', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_edc', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'keterangan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_edc'=>'',
            'kode_edc'=>'required',
            'nama_edc'=>'required',
            'keterangan'=>'',
            'is_active'=>'',
        ];
    }
}
