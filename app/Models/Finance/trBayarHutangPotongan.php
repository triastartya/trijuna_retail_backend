<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarHutangPotongan extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_hutang_potongan';
    
    protected $primaryKey = 'id_bayar_hutang_potongan';
    
    protected $fillable = [
        'id_bayar_hutang_potongan',
        'id_bayar_hutang',
        'id_retur_pembelian'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang_potongan'=>'',
            'id_bayar_hutang'=>'required',
            'id_retur_pembelian'=>'required'
        ];
    }
}
