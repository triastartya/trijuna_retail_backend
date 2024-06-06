<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posTutupKasirDetailPendapatan extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'pos_tutup_kasir_detail_pendapatan';
    
    protected $primaryKey = 'id_tutup_kasir';
    
    protected $fillable = [
        'id_tutup_kasir_detail_pendapatan',
        'id_tutup_kasir',
        'id_payment_method',
        'payment_method',
        'nominal'
    ];
    
    public function rules()
    {
        return [
            'id_tutup_kasir_detail_pendapatan' => '',
            'id_tutup_kasir' => 'required',
            'id_payment_method' => '',
            'payment_method' => '',
            'nominal' => ''
        ];
    }
}
