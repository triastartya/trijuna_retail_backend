<?php

namespace App\Models\Pembelian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trPemesananDetail extends Model
{
    use HasFactory;
    
    protected $table = 'tr_pemesanan_detail';
    
    protected $primaryKey = 'id_pemesanan_detail';
    
    protected $fillable = [
        'id_pemesanan_detail',
        'id_pemesanan',
        'urut',
        'id_barang',
        'banyak',
        'banyak_terima',
        'kode_satuan',
        'isi',
        'qty',
        'qty_terima',
        'harga_order',
        'diskon_persen_1',
        'diskon_nominal_1',
        'diskon_persen_2',
        'diskon_nominal_2',
        'diskon_persen_3',
        'diskon_nominal_3',
        'sub_total',
        'qty_bonus',
        'biaya_barcode',
        'nama_bonus'
    ];
    
    public function rules()
    {
        return [
            'id_pemesanan_detail'=>'',
            'id_pemesanan'=>'required',
            'urut'=>'required',
            'id_barang'=>'required',
            'banyak'=>'required',
            'banyak_terima'=>'',
            'kode_satuan'=>'required',
            'isi'=>'required',
            'qty'=>'required',
            'qty_terima'=>'',
            'harga_order'=>'required',
            'diskon_persen_1'=>'required',
            'diskon_nominal_1'=>'required',
            'diskon_persen_2'=>'required',
            'diskon_nominal_2'=>'required',
            'diskon_persen_3'=>'required',
            'diskon_nominal_3'=>'required',
            'sub_total'=>'required',
            'qty_bonus'=>'',
            'nama_bonus'=>'',
        ];
    }
}
