<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingStokOpnameDivisi extends Model
{
    use HasFactory;

    protected $table = 'tr_setting_stok_opname_divisi';
    protected $primaryKey = 'id_setting_stok_opname_divisi';
    protected $fillable = [
        'id_setting_stok_opname_divisi',
        'id_setting_stok_opname',
        'id_divisi',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_setting_stok_opname_divisi'=>'',
            'id_setting_stok_opname'=>'',
            'id_divisi'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}