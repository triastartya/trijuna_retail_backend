<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trInputStokOpname extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_input_stok_opname';
    protected $primaryKey = 'id_input_stok_opname';
    protected $fillable = [
        'id_input_stok_opname',
        'id_setting_stok_opname',
        'keterangan',
        'id_user',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_input_stok_opname'=>'',
            'id_setting_stok_opname'=>'',
            'keterangan'=>'',
            'id_user'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
