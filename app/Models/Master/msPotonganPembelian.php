<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msPotonganPembelian extends Model
{
    use HasFactory,VierModel;

    protected $table = 'ms_potongan_pembelian';
    protected $fillable = [
        'potongan_pembelian',
        'is_active'
    ];
    protected $primaryKey = 'id_potongan_pembelian';
    protected $modelFields = [
        ['name' => 'potongan_pembelian', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_potongan_pembelian'=>'',
            'potongan_pembelian'=>'required',
            'is_active'=>'',
        ];
    }
}
