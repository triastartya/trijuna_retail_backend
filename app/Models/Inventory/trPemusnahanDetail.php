<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trPemusnahanDetail extends Model
{
    use HasFactory;

    protected $table = 'tr_pemusnahan_detail';
    protected $primaryKey = 'tr_pemusnahan_detail';
    protected $fillable = [
        'id_pemusnahan_detail',
        'id_pemusnahan',
        'urut',
        'id_barang',
        'banyak',
        'kode_satuan',
        'isi',
        'qty',
        'hpp_average',
        'sub_total'
    ];
    public function rules(){
        return[
            'id_pemusnahan_detail'=> '',
            'id_pemusnahan'=> 'required',
            'urut' => 'required',
            'id_barang' => 'required',
            'kode_satuan' => 'required',
            'isi' => 'required',
            'qty' => 'required',
            'hpp_average' => 'required',
            'sub_total' => 'required'
        ];
    }
}
