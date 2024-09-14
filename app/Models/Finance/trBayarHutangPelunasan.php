<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class trBayarHutangPelunasan extends Model
{
    use HasFactory,CreatedUpdatedBy;
    protected $table = 'tr_bayar_hutang_pelunasan';
    
    protected $primaryKey = 'id_bayar_hutang_pelunasan';
    
    protected $fillable = [
        'id_bayar_hutang_pelunasan',
        'id_bayar_hutang',
        'tanggal_bayar',
        'methode_bayar',
        'keterangan',
        'jumlah_bayar',
        'created_by',
        'updated_by',
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang_pelunasan'=>'',
            'id_bayar_hutang'=>'required',
            'tanggal_bayar'=>'required',
            'methode_bayar'=>'',
            'keterangan'=>'',
            'jumlah_bayar'=>'required',
            'created_by'=>'',
            'updated_by'=>'',
        ];
    }
}
