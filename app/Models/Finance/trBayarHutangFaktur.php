<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarHutangFaktur extends Model
{
    use HasFactory;
    protected $table = 'tr_bayar_hutang_faktur';
    
    protected $primaryKey = 'id_bayar_hutang_faktur';
    
    protected $fillable = [
        'id_bayar_hutang_faktur',
        'id_bayar_hutang',
        'id_penerimaan'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang_faktur'=>'',
            'id_bayar_hutang'=>'required',
            'id_penerimaan'=>'required'
        ];
    }
}
