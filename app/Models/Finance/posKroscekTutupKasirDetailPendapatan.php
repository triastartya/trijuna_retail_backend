<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Viershaka\Vier\VierModel;

class posKroscekTutupKasirDetailPendapatan extends Model
{
    use HasFactory, VierModel, CreatedUpdatedBy;

    protected $table = 'pos_kroscek_tutup_kasir_detail_pendapatan';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_kroscek_tutup_kasir',
        'id_payment_method',
        'payment_method',
        'nominal',
        'created_at',
        'updated_at'
    ];
    
    public function rules()
    {
        return [
            'id' => '',
            'id_kroscek_tutup_kasir' => 'required',
            'id_payment_method' => '',
            'payment_method' => '',
            'nominal' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
    }
}
