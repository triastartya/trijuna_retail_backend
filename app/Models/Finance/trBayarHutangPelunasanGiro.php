<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarHutangPelunasanGiro extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_hutang_pelunasan_giro';
    
    protected $primaryKey = 'id_bayar_hutang_pelunasan_giro';
    
    protected $fillable = [
        'id_bayar_hutang_pelunasan_giro',
        'id_bayar_hutang_pelunasan',
        'no_giro',
        'tanggal_jatuh_tempo',
        'nominal_bayar'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang_pelunasan_giro'=>'',
            'id_bayar_hutang_pelunasan'=>'required',
            'no_giro'=>'required',
            'tanggal_jatuh_tempo'=>'required',
            'nominal_bayar'=>'required'
        ];
    }
}
