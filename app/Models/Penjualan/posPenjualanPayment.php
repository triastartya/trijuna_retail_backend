<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;


class posPenjualanPayment extends Model
{
    use HasFactory;
    protected $table = 'pos_penjualan_peyment';
    protected $primaryKey = 'id_penjualan_peyment';
    protected $fillable = [
        'id_penjualan_peyment',
        'id_penjualan',
        'urut',
        'jenis_pembayar',
        'jumlah_bayar',
        'keterangan',
        'id_voucher',
        'id_payment_method',
        'id_bank',
        'id_edc',
        'trace_number',
        'jenis_kartu',
        'card_holder',
        'tanggal_jatuh_tempo_piutang',
        'keterangan_piutang'
    ];
    
    public function rules()
    {
        return [
            'id_penjualan_peyment'=>'',
            'id_penjualan'  =>'required',
            'urut'              =>'required',
            'jenis_pembayar'         =>'required',
            'jumlah_bayar'          =>'required',
            'keterangan'           =>'',
            'id_voucher'           =>'',
            'sub_total'         =>'required',
            'id_payment_method'   =>'',
            'id_bank'   =>'',
            'id_edc'   =>'',
            'trace_number'   =>'',
            'jenis_kartu'   =>'',
            'card_holder'   =>'',
            'tanggal_jatuh_tempo_piutang'   =>'',
            'keterangan_piutang'   =>''
        ];
    }
}
