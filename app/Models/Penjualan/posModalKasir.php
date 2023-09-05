<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class posModalKasir extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'pos_modal_kasir';
    protected $fillable = ['id_user_kasir','tanggal_modal_kasir','modal_kasir','id_tutup_kasir'];
    protected $primaryKey = 'id_modal_kasir';
    protected $modelFields = [
        ['name' => 'id_user_kasir', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'tanggal_modal_kasir', 'type' => ModelDictionary::COLUMN_TYPE_DATE],
        ['name' => 'modal_kasir', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name'=>'id_tutup_kasir','type'=>ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_modal_kasir'=>'',
            'id_user_kasir'=>'required',
            'tanggal_modal_kasir'=>'required',
            'modal_kasir'=>'required',
            'id_tutup_kasir'=>''
        ];
    }
}
