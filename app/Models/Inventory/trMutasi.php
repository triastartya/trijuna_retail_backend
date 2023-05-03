<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trMutasi extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_mutasi_warehouse';
    protected $primaryKey = 'id_mutasi_warehouse';
    protected $fillable = [
        'id_mutasi_warehouse',
        'tanggal_mutasi_warehouse',
        'warehouse_asal',
        'warehouse_tujuan',
        'qty',
        'total_harga',
        'status_mutasi_warehouse',
        'id_barang_stok',
        'is_deleted',
        'deleted_by',
        'deleted_at'
    ];
    public function rules(){
        return[
            'id_mutasi_warehouse'=>'',
            'tanggal_mutasi_warehouse'=>'required',
            'warehouse_asal'=>'required',
            'warehouse_tujuan'=>'required',
            'qty'=>'required',
            'total_harga'=>'required',
            'status_mutasi_warehouse'=>'required',
            'id_barang_stok'=>'',
            'is_deleted'=>'',
            'deleted_by'=>'',
            'deleted_at'=>''
        ];
    }
}
