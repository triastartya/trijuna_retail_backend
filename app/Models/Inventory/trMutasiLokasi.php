<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trMutasiLokasi extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_mutasi_lokasi';
    protected $primaryKey = 'id_mutasi_lokasi';
    protected $fillable = [
        'id_mutasi_lokasi',
        'nomor_mutasi_lokasi',
        'tanggal_mutasi_lokasi',
        'id_lokasi_asal',
        'warehouse_asal',
        'id_lokasi_tujuan',
        'warehouse_tujuan',
        'qty',
        'total_harga',
        'status_mutasi_lokasi',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'deleted_reason',
        'created_by',
        'updated_by',
        'jenis_mutasi',
        'online',
        'no_mutasi_keluar',
        'download'
    ];
    public function rules(){
        return[
            'id_tr_mutasi_lokasi'=>'',
            'no_mutasi_lokasi'=>'required',
            'tanggal_mutasi_lokasi'=>'required',
            'id_lokasi_asal'=>'required',
            'warehouse_asal'=>'required',
            'id_lokasi_tujuan'=>'required',
            'warehouse_tujuan'=>'required',
            'qty'=>'',
            'total_harga'=>'',
            'status_mutasi_lokasi'=>'',
            'is_deleted'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
            'deleted_reason'=>'',
            'created_by'=>'',
            'updated_by'=>'',
            'jenis_mutasi'=>'',
            'online'=>'',
            'no_mutasi_keluar'=>'',
            'download'=>''
        ];
    }
}
