<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarHutangPotonganLain extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_hutang_potongan_lain';
    
    protected $primaryKey = 'id_bayar_hutang_potongan_lain';
    
    protected $fillable = [
        'id_bayar_hutang_potongan_lain',
        'id_bayar_hutang',
        'id_potongan_pembelian',
        'potongan_pembelian',
        'total_potongan'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang_potongan_lain'=>'',
            'id_bayar_hutang'=>'required',
            'id_potongan_pembelian'=>'required',
            'potongan_pembelian'=>'',
            'total_potongan'=>'required',
        ];
    }
}
