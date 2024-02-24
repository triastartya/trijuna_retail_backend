<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarPiutangPayment extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_piutang_payment';
    
    protected $primaryKey = 'id_bayar_piutang_payment';
    
    protected $fillable = [
        'id_bayar_piutang_payment',
        'id_bayar_piutang',
        'tanggal_bayar_piutang',
        'cara_bayar',
        'id_rekening_pengirim',
        'no_rekening_pengirim',
        'bank_pengirim',
        'atas_nama_pengirim',
        'id_rekening_penerima',
        'no_rekening_penerima',
        'bank_penerima',
        'atas_nama_penerima',
        'keterangan',
        'total_bayar'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_piutang_payment'=>'',
            'id_bayar_piutang'=>'required',
            'tanggal_bayar_piutang'=>'required',
            'cara_bayar'=>'required',
            'id_rekening_pengirim'=>'',
            'no_rekening_pengirim'=>'',
            'bank_pengirim'=>'',
            'atas_nama_pengirim'=>'',
            'id_rekening_penerima'=>'',
            'no_rekening_penerima'=>'',
            'bank_penerima'=>'',
            'atas_nama_penerima'=>'',
            'keterangan'=>'',
            'total_bayar'=>'required'
        ];
    }
}
