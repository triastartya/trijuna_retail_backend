<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Viershaka\Vier\VierModel;

class posTutupKasirDetailPendapatan extends Model
{
    use HasFactory,VierModel;
    
    protected $table = 'pos_tutup_kasir_detail_pendapatan';
    protected $fillable = [
        'id_tutup_kasir_detail_pendapatan',
        'id_tutup_kasir',
        'id_payment_method',
        'payment_method',
        'nominal'
    ];
    
    protected $primaryKey = 'id_tutup_kasir_detail_pendapatan';
    public function rules()
    {
        return [
            'id_tutup_kasir_detail_pendapatan'=>'',
            'id_tutup_kasir'=>'required',
            'id_payment_method'=>'required',
            'payment_method'=>'required',
            'nominal'=>'required'
        ];
    }
}
