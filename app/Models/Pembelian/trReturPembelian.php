<?php

namespace App\Models\Pembelian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class trReturPembelian extends Model
{
    use HasFactory,CreatedUpdatedBy;
    
    protected $table = 'tr_retur_pembelian';
    protected $primaryKey = 'id_retur_pembelian';
    protected $fillable = [
        'id_retur_pembelian',
        'jenis_retur',
        'nomor_retur_pembelian',
        'tanggal_retur_pembelian',
        'id_warehouse',
        'id_supplier',
        'mekanisme',
        'total_harga',
        'qty',
        'status_retur',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'deleted_reason',
        'created_by',
        'updated_by'
    ];
    
    public function rules()
    {
        return [
            'id_retur_pembelian'=>'',
            'jenis_retur'=>'',
            'nomor_retur_pembelian'=>'required',
            'tanggal_retur_pembelian'=>'required',
            'id_warehouse'=>'required',
            'id_supplier'=>'required',
            'mekanisme'=>'required',
            'total_harga'=>'required',
            'qty'=>'required',
            'status_retur'=>'required',
            'is_deleted'=>'required',
            'deleted_by'=>'required',
            'deleted_at'=>'required',
            'deleted_reason'=>'required',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
