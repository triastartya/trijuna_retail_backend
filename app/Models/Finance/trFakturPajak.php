<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trFakturPajak extends Model
{
    use HasFactory,CreatedUpdatedBy;
    protected $table = 'tr_faktur_pajak';
    
    protected $primaryKey = 'id_faktur_pajak';
    
    protected $fillable = [
        'id_faktur_pajak',
        'id_penerimaan',
        'total_transaksi',
        'dasar_pengenaan_pajak',
        'ppn',
        'no_seri',
        'tanggal_faktur_pajak',
        'nama_ttd_faktur',
        'keterangan',
        'deleted_by',
        'deleted_at'
    ];
    
    public function rules()
    {
        return [
            'id_faktur_pajak'=>'',
            'id_penerimaan'=>'required',
            'total_transaksi'=>'required',
            'dasar_pengenaan_pajak'=>'required',
            'ppn'=>'required',
            'no_seri'=>'required',
            'tanggal_faktur_pajak'=>'required',
            'nama_ttd_faktur'=>'required',
            'keterangan'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
        ];
    }
}