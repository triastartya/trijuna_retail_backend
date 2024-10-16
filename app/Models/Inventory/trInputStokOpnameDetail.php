<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trInputStokOpnameDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_input_stok_opname_detail';
    protected $primaryKey = 'id_input_stok_opname_detail';
    protected $fillable = [
        'id_input_stok_opname_detail',
        'id_input_stok_opname',
        'id_barang',
        'qty_fisik',
        'keterangan',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_input_stok_opname_detail'=>'',
            'id_input_stok_opname'=>'',
            'id_barang'=>'',
            'qty_fisik'=>'',
            'keterangan'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
