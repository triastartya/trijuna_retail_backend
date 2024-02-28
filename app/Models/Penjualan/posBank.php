<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class posBank extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'pos_bank';
    protected $fillable = ['id_bank','kode_bank','nama_bank','biaya','is_active'];
    protected $primaryKey = 'id_bank';
    protected $modelFields = [
        ['name' => 'kode_bank', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_bank', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'biaya', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_bank'=>'',
            'kode_bank'=>'required',
            'nama_bank'=>'required',
            'biaya'=>'',
            'is_active'=>'',
        ];
    }
}
