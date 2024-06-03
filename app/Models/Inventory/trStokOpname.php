<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trStokOpname extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_audit_stok_opname';
    protected $primaryKey = 'id_audit_stok_opname';
    protected $fillable = [
        'id_audit_stok_opname',
        'nomor_audit_stok_opname',
        'id_warehouse',
        'id_setting_stok_opname',
        'id_group',
        'id_rak',
        'waktu_capture_stok',
        'jumlah_fisik',
        'jumlah_sistem_capture_stok',
        'total_nominal_sistem_capture_stok',
        'waktu_capture_stok_adj',
        'jumlah_fisik_adj',
        'total_nominal_fisik_adj',
        'jumlah_sistem_capture_stok_adj',
        'total_nominal_sistem_capture_stok_adj',
        'keterangan',
        'keterangan_adj',
        'keterangan_proses',
        'status',
        'created_by',
        'updated_by',
        'created_by_adj',
        'created_by_proses'
    ];
    public function rules(){
        return[
            'id_audit_stok_opname'=>'',
            'nomor_audit_stok_opname'=>'required',
            'id_warehouse'=>'required',
            'id_setting_stok_opname'=>'required',
            'id_group'=>'',
            'id_rak'=>'',
            'waktu_capture_stok'=>'',
            'jumlah_fisik'=>'required',
            'total_nominal_fisik'=>'required',
            'jumlah_sistem_capture_stok'=>'required',
            'total_nominal_sistem_capture_stok'=>'required',
            'waktu_capture_stok_adj'=>'',
            'jumlah_fisik_adj'=>'',
            'total_nominal_fisik_adj'=>'',
            'jumlah_sistem_capture_stok_adj'=>'',
            'total_nominal_sistem_capture_stok_adj'=>'',
            'jumlah_proses_selisih'=>'',
            'total_nominal_proses_selisih'=>'',
            'keterangan'=>'',
            'keterangan_adj'=>'',
            'keterangan_proses'=>'',
            'status'=>'',
            'created_by'=>'',
            'updated_by'=>'',
            'created_by_adj'=>'',
            'created_by_proses'=>''
        ];
    }
}
