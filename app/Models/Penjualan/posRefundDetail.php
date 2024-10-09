<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posRefundDetail extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'pos_refund_detail';
    protected $primaryKey = 'id_refund_detail';
    protected $fillable = [
        'id_refund_detail',
        'id_refund',
        'urut',
        'id_barang',
        'qty_jual',
        'kode_satuan',
        'harga_jual',
        'diskon1',
        'diskon2',
        'display_diskon1',
        'display_diskon2',
        'sub_total'
    ];
    
    public function rules()
    {
        return [
            'id_refund_detail'  =>'',
            'id_refund'         =>'required',
            'urut'              =>'required',
            'id_barang'         =>'required',
            'qty_jual'          =>'required',
            'kode_satuan'       =>'required',
            'harga_jual'        =>'required',
            'diskon1'           =>'',
            'diskon2'           =>'',
            'display_diskon1'   =>'',
            'display_diskon2'   =>'',
            'sub_total'        =>'required',
        ];
    }
}
