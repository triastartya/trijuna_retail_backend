<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trMutasiDetail extends Model
{
    use HasFactory;

    protected $table = 'tr_mutasi_warehouse_detail';
    protected $primaryKey = 'id_mutasi_warehouse_detail';
    protected $fillable = [
        'id_mutasi_warehouse_detail',
        'id_mutasi_warehouse',
        'urut',
        'id_barang',
        'banyak',
        'kode_satuan',
        'isi',
        'qty',
        'harga_satuan',
        'sub_total'
    ];
    public function rules(){
        return[
            'id_mutasi_warehouse_detail',
            'id_mutasi_warehouse' => 'required',
            'urut' => '',
            'id_barang' => 'required',
            'banyak' => 'required',
            'kode_satuan' => 'required',
            'isi' => '',
            'qty' => 'required',
            'harga_satuan' => 'required',
            'sub_total' => ''
        ];
    }
}
