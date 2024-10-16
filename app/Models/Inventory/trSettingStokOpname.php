<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingStokOpname extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_setting_stok_opname';
    protected $primaryKey = 'id_setting_stok_opname';
    protected $fillable = [
        'id_setting_stok_opname',
        'nomor_stok_opname',
        'tanggal_setting_stok_opname',
        'jenis_stok_opname',
        'id_warehouse',
        'keterangan',
        'total_fisik_harga_jual',
        'total_capture_harga_jual',
        'total_selisih_harga_jual',
        'total_capture_hpp_average',
        'total_fisik_hpp_average',
        'total_selisih_hpp_average',
        'created_by',
        'updated_by',
        'status',
        'finalisasi_at',
        'finalisasi_by',
        'finalisasi_keterangan'
    ];
    public function rules(){
        return[
            'id_setting_stok_opname'=>'',
            'nomor_stok_opname'=>'',
            'tanggal_setting_stok_opname'=>'',
            'jenis_stok_opname'=>'',
            'id_warehouse'=>'',
            'keterangan'=>'',
            'total_fisik_harga_jual'=>'',
            'total_capture_harga_jual'=>'',
            'total_selisih_harga_jual'=>'',
            'total_capture_hpp_average'=>'',
            'total_fisik_hpp_average'=>'',
            'total_selisih_hpp_average'=>'',
            'created_by'=>'',
            'updated_by'=>'',
            'status'=>'',
            'finalisasi_at'=>'',
            'finalisasi_by'=>'',
            'finalisasi_keterangan'=>''
        ];
    }
}
