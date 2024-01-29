<?php

namespace App\Models\Penjualan;

use Viershaka\Vier\VierModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class posTutupKasir extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'pos_tutup_kasir';
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
        'deleted_at',
        'deleted_reason',
        'created_by',
        'updated_by'
    ];
    
    protected $primaryKey = 'id_tutup_kasir';
    public function rules()
    {
        return [
            'id_tutup_kasir'=>'',
            'id_user_kasir'=>'required',
            'tanggal_tutup_kasir'=>'required',
            'modal_kasir'=>'required',
            'pengeluaran'=>'required',
            'penerimaan'=>'required',
            'sisa_saldo'=>'required',
            'keterangan'=>'',
            'status_tutup_kasir'=>'required',
            'id_kroscek_tutup_kasir'=>'',
            'is_deleted'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
        ];
    }
}
