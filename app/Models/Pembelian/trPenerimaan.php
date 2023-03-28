<?php

namespace App\Models\Pembelian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;


class trPenerimaan extends Model
{
    use HasFactory,CreatedUpdatedBy;
    protected $table = 'tr_penerimaan';
    protected $primaryKey = 'id_penerimaan';
    protected $fillable = [
        'id_penerimaan',
        'jenis_penerimaan',
        'id_pemesanan',
        'nomor_penerimaan',
        'tanggal_penerimaan',
        'no_nota',
        'tanggal_nota',
        'id_lokasi',
        'id_warehouse',
        'keterangan',
        'status_penerimaan',
        'qty',
        'sub_total1',
        'diskon_persen',
        'diskon_nominal',
        'sub_total2',
        'ppn_nominal',
        'pembulatan',
        'total_transaksi',
        'total_biaya_barcode',
        'is_deleted',
        'deleted_by',
        'deleted_at'
    ];
    
    public function rules()
    {
        return [
            'jenis_penerimaan'=>'',
            'id_pemesanan'=>'required',
            'nomor_penerimaan'=>'required',
            'tanggal_penerimaan'=>'required',
            'no_nota'=>'required',
            'tanggal_nota'=>'required',
            'id_lokasi'=>'required',
            'id_warehouse'=>'required',
            'keterangan'=>'',
            'status_penerimaan'=>'required',
            'qty'=>'required',
            'sub_total1'=>'required',
            'diskon_persen'=>'required',
            'diskon_nominal'=>'',
            'sub_total2'=>'',
            'ppn_nominal'=>'required',
            'pembulatan'=>'required',
            'total_transaksi'=>'required',
            'total_biaya_barcode'=>'required',
            'is_deleted'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
        ];
    }
}
