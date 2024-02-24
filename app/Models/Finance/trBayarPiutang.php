<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarPiutang extends Model
{
    use HasFactory,CreatedUpdatedBy;
    protected $table = 'tr_bayar_piutang';
    
    protected $primaryKey = 'id_bayar_piutang';
    
    protected $fillable = [
        'id_bayar_piutang',
        'tanggal_bayar',
        'nomor_bayar_piutang',
        'total_bayar_piutang',
        'keterangan',
        'deleted_by',
        'deleted_at'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_piutang'=>'',
            'tanggal_bayar'=>'required',
            'nomor_bayar_piutang'=>'required',
            'total_bayar_piutang'=>'required',
            'keterangan'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
        ];
    }
}
