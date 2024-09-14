<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarHutangPelunasanTransfer extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_hutang_pelunasan_transfer';
    
    protected $primaryKey = 'id_bayar_hutang_pelunasan_transfer';
    
    protected $fillable = [
        'id_bayar_hutang_pelunasan_transfer',
        'id_bayar_hutang_pelunasan',
        'id_rekening',
        'waktu_bayar',
        'nominal_bayar'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang_pelunasan_transfer'=>'',
            'id_bayar_hutang_pelunasan'=>'required',
            'id_rekening'=>'required',
            'waktu_bayar'=>'required',
            'nominal_bayar'=>'required'
        ];
    }
}
