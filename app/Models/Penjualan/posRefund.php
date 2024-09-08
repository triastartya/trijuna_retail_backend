<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class posRefund extends Model
{
    use HasFactory,CreatedUpdatedBy;
    protected $table = 'pos_refund';
    protected $primaryKey = 'id_refund';
    protected $fillable = [
        'id_refund',
        'no_retur_penjualan',
        'id_user_kasir',
        'id_penjualan',
        'tanggal_refund',
        'keterangan',
        'total_refund',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'deleted_reason',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'id_tutup_kasir'
    ];
    
    public function rules()
    {
        return [
        'id_refund'=>'',
        'no_retur_penjualan'=>'required',
        'id_user_kasir'=>'required',
        'id_penjualan'=>'required',
        'tanggal_refund'=>'required',
        'keterangan'=>'required',
        'total_refund'=>'required',
        'is_deleted'=>'',
        'deleted_by'=>'',
        'deleted_at'=>'',
        'deleted_reason'=>'',
        'created_by'=>'required',
        'created_at'=>'required',
        'updated_by'=>'required',
        'updated_at'=>'required',
        'id_tutup_kasir'=>'',
        ];
    }
}
