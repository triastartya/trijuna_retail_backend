<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trStokOpnameDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $table = 'tr_audit_stok_opname_detail';
    protected $primaryKey = 'id_audit_stok_opname_detail';
    protected $fillable = [
        'id_audit_stok_opname_detail',
        'id_audit_stok_opname',
        'no_urut',
        'id_barang',
        'harga_jual',
        'hpp_avarage',
        'waktu_capture_stok',
        'qty_fisik',
        'qty_sistem_capture_stok',
        'sub_total_sistem_capture_stok',
        'waktu_capture_stok_adj',
        'qty_fisik_adj',
        'qty_sistem_capture_stok_adj',
        'sub_total_fisik_adj',
        'sub_total_sistem_capture_stok_adj',
        'sub_total_proses_selisih',
        'qty_proses_selisih',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
        'id_audit_stok_opname_detail'=>'',
        'id_audit_stok_opname'=>'required',
        'no_urut'=>'required',
        'id_barang'=>'required',
        'harga_jual'=>'required',
        'hpp_avarage'=>'required',
        'waktu_capture_stok'=>'required',
        'qty_fisik'=>'required',
        'qty_sistem_capture_stok'=>'required',
        'sub_total_sistem_capture_stok'=>'',
        'waktu_capture_stok_adj'=>'',
        'qty_fisik_adj'=>'',
        'qty_sistem_capture_stok_adj'=>'',
        'sub_total_fisik_adj'=>'',
        'sub_total_sistem_capture_stok_adj'=>'',
        'qty_proses_selisih'=>'required',
        'sub_total_proses_selisih'=>'required',
        'created_by'=>'',
        'updated_by'=>''
        ];
    }
}
