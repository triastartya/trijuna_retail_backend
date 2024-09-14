<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trBayarHutang extends Model
{
    use HasFactory,CreatedUpdatedBy;
    protected $table = 'tr_bayar_hutang';
    
    protected $primaryKey = 'id_bayar_hutang';
    
    protected $fillable = [
        'id_bayar_hutang',
        'id_supplier',
        'nomor_titip_tagihan',
        'tanggal_titip_tagihan',
        'tanggal_rencana_bayar',
        'keterangan',
        'total_titip_tagihan',
        'total_potongan',
        'total_retur',
        'total_bayar',
        'is_lunas',
        'tanggal_lunas',
        'deleted_by',
        'deleted_at'
    ];
    
    public function rules()
    {
        return [
            'id_bayar_hutang'=>'',
            'id_supplier',
            'nomor_titip_tagihan'=>'required',
            'tanggal_titip_tagihan'=>'required',
            'tanggal_rencana_bayar'=>'required',
            'keterangan'=>'',
            'total_titip_tagihan'=>'required',
            'total_potongan'=>'required',
            'total_retur'=>'required',
            'total_bayar'=>'required',
            'is_lunas'=>'',
            'tanggal_lunas'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
        ];
    }
}
