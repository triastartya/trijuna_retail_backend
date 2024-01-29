<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;


class posPenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'pos_penjualan_detail';
    protected $primaryKey = 'id_pos_penjualan_detail';
    protected $fillable = [
        'id_pos_penjualan_detail',
        'id_penjualan',
        'urut',
        'id_barang',
        'qty_jual',
        'kode_satuan',
        'harga_jual',
        'diskon1',
        'diskon2',
        'sub_total',
        'display_diskon1',
        'display_diskon2'
    ];
    
    public function rules()
    {
        return [
            'id_pos_penjualan_detail'=>'',
            'id_penjualan'  =>'required',
            'urut'              =>'required',
            'id_barang'         =>'required',
            'qty_jual'          =>'required',
            'diskon1'           =>'',
            'diskon2'           =>'',
            'sub_total'         =>'required',
            'display_diskon1'   =>'',
            'display_diskon2'   =>''
        ];
    }
}
