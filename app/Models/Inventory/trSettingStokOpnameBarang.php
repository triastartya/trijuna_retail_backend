<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingStokOpnameBarang extends Model
{
    use HasFactory;

    protected $table = 'tr_setting_stok_opname_barang';
    protected $primaryKey = 'id_setting_stok_opname_barang';
    protected $fillable = [
        'id_setting_stok_opname_barang',
        'id_setting_stok_opname',
        'id_barang',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_setting_stok_opname_barang'=>'',
            'id_setting_stok_opname'=>'',
            'id_barang'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
