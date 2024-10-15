<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingStokOpnameSupplier extends Model
{
    use HasFactory;

    protected $table = 'tr_setting_stok_opname_supplier';
    protected $primaryKey = 'id_setting_stok_opname_supplier';
    protected $fillable = [
        'id_setting_stok_opname_supplier',
        'id_setting_stok_opname',
        'id_supplier',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_setting_stok_opname_supplier'=>'',
            'id_setting_stok_opname'=>'',
            'id_supplier'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
