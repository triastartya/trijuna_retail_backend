<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trProduksiDetail extends Model
{
    use HasFactory;

    protected $table = 'tr_produksi_detail';
    protected $primaryKey = 'id_produksi_detail';
    protected $fillable = [
        'id_produksi_detail',
        'id_produksi',
        'urut',
        'id_barang',
        'kode_satuan',
        'qty',
        'hpp_average',
        'sub_total'
    ];
    public function rules(){
        return[
            'id_produksi_detail'=> '',
            'id_produksi'=> 'required',
            'urut' => 'required',
            'id_barang' => 'required',
            'kode_satuan' => 'required',
            'qty' => 'required',
            'hpp_average' => 'required',
            'sub_total' => 'required'
        ];
    }
}
