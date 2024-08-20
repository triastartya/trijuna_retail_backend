<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posTutupKasirDetailPendapatanCash extends Model
{
    use HasFactory;

    protected $table = 'pos_tutup_kasir_detail_pendapatan_cash';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_tutup_kasir_detail_pendapatan',
        'nominal',
        'bayar',
        'kembalian'
    ];
    
    public function rules()
    {
        return [
            'id' => '',
            'id_tutup_kasir_detail_pendapatan' => 'required',
            'nominal' => 'required',
            'bayar' => 'required',
            'kembalian' => 'required'
        ];
    }
}
