<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarPiutangNota extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_piutang_nota';
    
    protected $primaryKey = 'id_bayar_piutang_nota';
    
    protected $fillable = [
        'id_bayar_piutang_nota',
        'id_bayar_piutang',
        'id_penjualan'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_piutang_nota'=>'',
            'id_bayar_piutang'=>'required',
            'id_penjualan'=>'required',
            'deleted_by'=>'',
            'deleted_at'=>'',
        ];
    }
}
