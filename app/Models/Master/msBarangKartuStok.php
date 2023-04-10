<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msBarangKartuStok extends Model
{
    use HasFactory,VierModel;
    protected $table = 'ms_barang_kartu_stok';
    protected $fillable = [
        'tanggal',
        'id_barang',
        'id_warehouse',
        'nomor_reff',
        'id_header_trans',
        'id_detail_trans',
        'stok_awal',
        'nominal_awal',
        'stok_masuk',
        'nominal_masuk',
        'stok_keluar',
        'nominal_keluar',
        'stok_akhir',
        'nominal_akhir',
        'keterangan',
    ];
    protected $primaryKey = 'id_kartu_stok';
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'tanggal'=>'required',
            'id_barang'=>'required',
            'id_warehouse'=>'required',
            'nomor_reff'=>'required',
            'id_header_trans'=>'required',
            'id_detail_trans'=>'required',
            'stok_awal'=>'required',
            'nominal_awal'=>'required',
            'stok_masuk'=>'required',
            'nominal_masuk'=>'required',
            'stok_keluar'=>'required',
            'nominal_keluar'=>'required',
            'stok_akhir'=>'required',
            'nominal_akhir'=>'required',
            'keterangan'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}
