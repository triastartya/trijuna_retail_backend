<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class posPengeluaran extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'pos_pengeluaran';
    protected $fillable = ['id_pengeluaran','nama_pengeluaran','keterangan','nominal'];
    protected $primaryKey = 'id_edc';
    protected $modelFields = [
        ['name' => 'id_pengeluaran', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_pengeluaran', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'keterangan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nominal', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_pengeluaran'=>'',
            'nama_pengeluaran'=>'required',
            'nama_edc'=>'required',
            'keterangan'=>'',
            'nominal'=>'required',
        ];
    }
}
