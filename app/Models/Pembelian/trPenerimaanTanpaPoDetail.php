<?php

namespace App\Models\Pembelian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trPenerimaanTanpaPoDetail extends Model
{
    use HasFactory;
    protected $table = 'tr_penerimaan_detail';
    protected $primaryKey = 'id_penerimaan_detail';
    protected $fillable = [
        'id_penerimaan_detail',
        'id_penerimaan',
        'urut',
        'id_barang',
        'banyak',
        'kode_satuan',
        'isi',
        'qty',
        'harga_order',
        'diskon_persen_1',
        'diskon_nominal_1',
        'diskon_persen_2',
        'diskon_nominal_2',
        'diskon_persen_3',
        'diskon_nominal_3',
        'sub_total',
        'biaya_barcode',
        'qty_bonus',
        'nama_bonus'
    ];
    
    public function rules()
    {
        return [
            'id_penerimaan_detail'  =>'',
            'id_penerimaan'         =>'required',
            'urut'                  =>'required',
            'id_barang'             =>'required',
            'banyak'                =>'required',
            'kode_satuan'           =>'required',
            'isi'                   =>'required',
            'qty'                   =>'required',
            'harga_order'           =>'required',
            'diskon_persen_1'       =>'required',
            'diskon_nominal_1'=>'required',
            'diskon_persen_2'=>'required',
            'diskon_nominal_2'=>'required',
            'diskon_persen_3'=>'required',
            'diskon_nominal_3'=>'required',
            'sub_total'=>'required',
            'biaya_barcode'=> '',
            'qty_bonus'=>'',
            'nama_bonus'=>'',
        ];
    }
}
