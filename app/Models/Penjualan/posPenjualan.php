<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;


class posPenjualan extends Model
{
    use HasFactory;
    protected $table = 'pos_penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = [
        'id_penjualan',
        'id_user_kasir',
        'is_bayar',
        'tanggal_penjualan',
        'nota_penjualan',
        'no_faktur',
        'id_member',
        'total_diskon_dalam',
        'total_transaksi',
        'diskon_luar_persen',
        'diskon_luar_nominal',
        'ongkos_kirim',
        'pembulatan',
        'total_transaksi2',
        'total_bayar',
        'kembali',
        'biaya_bank',
        'is_using_voucher',
        'id_pos_kasir',
        'id_tutup_kasir',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'created_by',
        'updated_by'
    ];
    
    public function rules()
    {
        return [
            'id_penjualan'=>'',
            'id_user_kasir'=>'required',
            'is_bayar'=>'required',
            'tanggal_penjualan'=>'required',
            'nota_penjualan'=>'required',
            'no_faktur'=>'required',
            'id_member'=>'',
            'total_diskon_dalam'=>'',
            'total_transaksi'=>'required',
            'diskon_luar_persen'=>'',
            'diskon_luar_nominal'=>'',
            'ongkos_kirim'=>'',
            'pembulatan'=>'',
            'total_transaksi2'=>'required',
            'total_bayar'=>'required',
            'kembali'=>'',
            'biaya_bank'=>'',
            'is_using_voucher'=>'',
            'id_pos_kasir'=>'required',
            'id_tutup_kasir'=>'',
            'is_deleted'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
        ];
    }
}
