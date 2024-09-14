<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class msRekeningOwner extends Model
{
    use HasFactory,VierModel;
    
    protected $table = 'ms_rekening_owner';
    protected $fillable = [
        'bank',
        'nama_rekening',
        'nomor_rekening'
    ];
    protected $primaryKey = 'id_rekening';
    protected $modelFields = [
        ['name' => 'bank', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_rekening', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nomor_rekening', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_rekening'=>'',
            'nama_rekening'=>'required',
            'nomor_rekening'=>'required',
            'bank'=>'required',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
