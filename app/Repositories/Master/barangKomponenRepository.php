<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangKomponen;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class barangKomponenRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangKomponen());
    }
    
    public function by_id_barang()
    {
        return DB::select('
            select
                mbk.id,
                mbk.id_barang,
                mbk.id_barang_komponen,
                mb.barcode,
                mb.kode_barang,
                mb.nama_barang,
                mbk.qty_komponen,
                mbk.created_by,
                mbk.updated_by,
                mbk.created_at,
                mbk.updated_at from ms_barang_komponen mbk
            inner join ms_barang mb on mbk.id_barang = mb.id_barang
            inner join users uc on uc.id_user = mbk.created_by
            inner join users uu on uu.id_user = mbk.updated_by
            where mbk.id_barang = ?
        ',[request()->id_barang]);
    }
}
