<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trProduksi extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_produksi';
    protected $primaryKey = 'id_produksi';
    protected $fillable = [
        'id_produksi',
        'nomor_produksi',
        'tanggal_produksi',
        'id_warehouse',
        'keterangan',
        'id_barang',
        'qty_produksi',
        'hpp_avarage_produksi',
        'total_hpp_avarage_produksi',
        'total_hpp_avarage_komponen',
        'status_produksi',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'deleted_reason',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_produksi'=>'',
            'nomor_produksi'=>'required',
            'tanggal_produksi'=>'required',
            'id_warehouse'=>'required',
            'keterangan'=>'',
            'id_barang'=>'required',
            'qty_produksi'=>'required',
            'hpp_avarage_produksi'=>'required',
            'total_hpp_avarage_produksi'=>'required',
            'total_hpp_avarage_komponen'=>'required',
            'status_produksi'=>'required',
            'is_deleted'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
            'deleted_reason'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}