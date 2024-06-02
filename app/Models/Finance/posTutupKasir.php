<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Viershaka\Vier\VierModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posTutupKasir extends Model
{
    use HasFactory, VierModel, CreatedUpdatedBy;

    protected $table = 'pos_tutup_kasir';
    
    protected $primaryKey = 'id_tutup_kasir';
    
    protected $fillable = [
        'id_tutup_kasir',
        'id_user_kasir',
        'tanggal_tutup_kasir',
        'modal_kasir',
        'pengeluaran',
        'penerimaan',
        'sisa_saldo',
        'keterangan',
        'status_tutup_kasir',
        'id_kroscek_tutup_kasir',
        'is_deleted',
        'deleted_by',
        'deleted_at'
    ];
    
    public function rules()
    {
        return [
            'id_tutup_kasir' => '',
            'id_user_kasir' => '',
            'tanggal_tutup_kasir' => '',
            'modal_kasir' => 'required',
            'pengeluaran' => 'required',
            'penerimaan' => 'required',
            'sisa_saldo' => 'required',
            'keterangan' => '',
            'status_tutup_kasir' => '',
            'id_kroscek_tutup_kasir' => '',
            'is_deleted' => '',
            'deleted_by' => '',
            'deleted_at' => ''
        ];
    }
}
