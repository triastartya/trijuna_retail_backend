<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarHutangPelunasanCash extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_hutang_pelunasan_cash';
    
    protected $primaryKey = 'id_bayar_hutang_pelunasan_cash';
    
    protected $fillable = [
        'id_bayar_hutang_pelunasan_cash',
        'id_bayar_hutang_pelunasan',
        'penerima_uang',
        'pemberi_uang',
        'keterangan',
        'waktu_penyerahan',
        'nominal_bayar'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang_pelunasan_cash'=>'',
            'id_bayar_hutang_pelunasan'=>'required',
            'penerima_uang'=>'required',
            'pemberi_uang'=>'required',
            'keterangan'=>'',
            'waktu_penyerahan'=>'required',
            'nominal_bayar'=>'required'
        ];
    }
}
