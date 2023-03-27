<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangUrai;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class barangUraiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangUrai());
    }
    
    public function by_id_barang()
    {
        return DB::select('
            select
                mbu.id_barang,
                mbu.id_barang_komponen,
                mb.barcode,
                mb.kode_barang,
                mb.nama_barang,
                mbu.qty_komponen,
                mbu.created_by,
                mbu.updated_by,
                mbu.created_at,
                mbu.updated_at from ms_barang_komponen mbu
            inner join ms_barang mb on mbu.id_barang = mb.id_barang
            inner join users uc on uc.id_user = mbu.created_by
            inner join users uu on uu.id_user = mbu.updated_by
            where mbu.id_barang = ?
        ',[request()->id_barang]);
    }
}
