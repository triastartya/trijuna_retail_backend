<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangSatuan;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class barangSatuanRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangSatuan());
    }
    
    public function by_id_barang()
    {
        return DB::select('
            select mbs.id_brang_satuan,
            mbs.id_barang,
            mbs.id_satuan,
            ms.kode_satuan,
            ms.nama_satuan,
            uc.nama as created_by,
            uu.nama as updated_by,
            mbs.created_at,
            mbs.updated_at from ms_barang_satuan mbs
            inner join ms_satuan ms on ms.id_satuan=mbs.id_satuan
            inner join users uc on uc.id_user = mbs.created_by
            inner join users uu on uu.id_user = mbs.updated_by
            where mbs.id_barang = ?
        ',[request()->id_barang]);
    }
}
