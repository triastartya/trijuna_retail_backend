<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trRepackingDetail extends Model
{
    use HasFactory;

    protected $table = 'tr_repacking_detail';
    protected $primaryKey = 'id_repacking_detail';
    protected $fillable = [
        'id_repacking_detail',
        'id_repacking',
        'urut',
        'id_barang',
        'kode_satuan',
        'qty',
        'hpp_average',
        'sub_total'
    ];
    public function rules(){
        return[
            'id_repacking_detail'=> '',
            'id_repacking'=> 'required',
            'urut' => 'required',
            'id_barang' => 'required',
            'kode_satuan' => 'required',
            'qty' => 'required',
            'hpp_average' => 'required',
            'sub_total' => 'required'
        ];
    }
}
