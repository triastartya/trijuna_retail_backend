<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Viershaka\Vier\VierModel;

class posKroscekTutupKasir extends Model
{
    use HasFactory, VierModel, CreatedUpdatedBy;

    protected $table = 'pos_kroscek_tutup_kasir';
    
    protected $primaryKey = 'id_kroscek_tutup_kasir';
    
    protected $fillable = [
        'id_kroscek_tutup_kasir',
        'id_tutup_kasir',
        'tanggal_kroscek_tutup_kasir',
        'pendapatan_versi_user',
        'pendapatan_versi_system',
        'selisih',
        'keterangan',
        'created_by',
        'updated_by'
    ];
    
    public function rules()
    {
        return [
            'id_kroscek_tutup_kasir'=>'',
            'tanggal_kroscek_tutup_kasir'=>'required',
            'id_tutup_kasir'=>'required',
            'pendapatan_versi_user'=>'required',
            'pendapatan_versi_system'=>'required',
            'selisih'=>'',
            'keterangan'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
