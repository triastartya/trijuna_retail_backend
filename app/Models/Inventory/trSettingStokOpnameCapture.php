<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingStokOpnameCapture extends Model
{
    use HasFactory;

    protected $table = 'tr_setting_stok_opname_capture';
    protected $primaryKey = 'id_setting_stok_opname_capture';
    protected $fillable = [
        'id_setting_stok_opname_capture',
        'id_setting_stok_opname',
        'id_barang',
        'tanggal_setting_stok_opname',
        'qty_fisik',
        'qty_capture',
        'qty_selisih',
        'keterangan',
        'hpp_average',
        'harga_jual',
        'sub_total_fisik_harga_jual',
        'sub_total_capture_harga_jual',
        'sub_total_selisih_harga_jual',
        'sub_total_fisik_hpp_average',
        'sub_total_capture_hpp_average',
        'sub_total_selisih_hpp_average'
    ];
    public function rules(){
        return[
            'id_setting_stok_opname_capture'=>'',
            'id_setting_stok_opname'=>'',
            'id_barang'=>'',
            'tanggal_setting_stok_opname'=>'',
            'qty_fisik'=>'',
            'qty_capture'=>'',
            'qty_selisih'=>'',
            'keterangan'=>'',
            'hpp_average'=>'',
            'harga_jual'=>'',
            'sub_total_fisik_harga_jual'=>'',
            'sub_total_capture_harga_jual'=>'',
            'sub_total_selisih_harga_jual'=>'',
            'sub_total_fisik_hpp_average'=>'',
            'sub_total_capture_hpp_average'=>'',
            'sub_total_selisih_hpp_average'=>''
        ];
    }
}
