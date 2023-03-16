<?php

namespace App\Models\Pembelian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trPemesanan extends Model
{
    use HasFactory;
    
    protected $table = 'tr_pemesanan';
    
    protected $primaryKey = 'id_pemesanan';
    
    protected $fillable = [
        'id_supplier',
        'nomor_pemesanan',
        'tanggal_pemesanan',
        'tangal_expired_pemesanan',
        'id_lokasi',
        'id_warehouse',
        'tanggal_kirim',
        'keterangan',
        'status_pemesanan',
        'qty',
        'sub_total1',
        'diskon_persen',
        'diskon_nominal',
        'sub_total2',
        'ppn_nominal',
        'total_transaksi',
        'is_deleted',
        'user_deleted',
        'time_deleted'
    ];
    
    public function rules()
    {
        return [
            'id_pemesanan'=>'',
            'id_supplier'=>'required',
            'nomor_pemesanan'=>'required',
            'tanggal_pemesanan'=>'required',
            'tangal_expired_pemesanan'=>'required',
            'id_lokasi'=>'required',
            'id_warehouse'=>'required',
            'tanggal_kirim'=>'required',
            'keterangan'=>'',
            'status_pemesanan'=>'required',
            'qty'=>'required',
            'sub_total1'=>'required',
            'diskon_persen'=>'',
            'diskon_nominal'=>'',
            'sub_total2'=>'required',
            'ppn_nominal'=>'required',
            'total_transaksi'=>'required',
            'is_deleted'=>'',
            'user_deleted'=>'',
            'time_deleted'=>'',
        ];
    }
}
