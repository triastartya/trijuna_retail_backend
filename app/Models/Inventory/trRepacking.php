<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trRepacking extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_repacking';
    protected $primaryKey = 'id_repacking';
    protected $fillable = [
        'id_repacking',
        'nomor_repacking',
        'tanggal_repacking',
        'id_warehouse',
        'keterangan',
        'id_barang',
        'qty_repacking',
        'hpp_avarage_repacking',
        'total_hpp_avarage_repacking',
        'total_hpp_avarage_urai',
        'status_repacking',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'deleted_reason',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_repacking'=>'',
            'nomor_repacking'=>'required',
            'tanggal_repacking'=>'required',
            'id_warehouse'=>'required',
            'keterangan'=>'',
            'id_barang'=>'required',
            'qty_repacking'=>'required',
            'hpp_avarage_repacking'=>'required',
            'total_hpp_avarage_repacking'=>'required',
            'total_hpp_avarage_urai'=>'required',
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