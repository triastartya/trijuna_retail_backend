<?php

namespace App\Models\Pembelian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trReturPembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'tr_retur_pembelian_detail';
    protected $primaryKey = 'id_retur_pembelian_detail';
    protected $fillable = [
        'id_retur_pembelian_detail',
        'id_retur_pembelian',
        'urut',
        'id_barang',
        'banyak',
        'kode_satuan',
        'isi',
        'qty',
        'harga_satuan',
        'sub_total'
    ];
    
    public function rules()
    {
        return [
            'id_retur_pembelian_detail'  =>'',
            'id_retur_pembelian'         =>'required',
            'urut'                  =>'required',
            'id_barang'             =>'required',
            'banyak'                =>'required',
            'kode_satuan'           =>'required',
            'isi'                   =>'required',
            'qty'                   =>'required',
            'harga_satuan'          =>'required',
            'sub_total'             =>'required'
        ];
    }
}
