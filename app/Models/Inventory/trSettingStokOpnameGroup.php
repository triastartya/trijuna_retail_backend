<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingStokOpnameGroup extends Model
{
    use HasFactory;

    protected $table = 'tr_setting_stok_opname_group';
    protected $primaryKey = 'id_setting_stok_opname_group';
    protected $fillable = [
        'id_setting_stok_opname_group',
        'id_setting_stok_opname',
        'id_group',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_setting_stok_opname_group'=>'',
            'id_setting_stok_opname'=>'',
            'id_group'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
