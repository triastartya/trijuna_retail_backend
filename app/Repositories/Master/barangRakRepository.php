<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangRak;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class barangRakRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangRak());
    }
    
    public function by_id_barang(){
        return DB::select('
            select  mbr.id_barang_rak,
            mbr.id_barang,
            mbr.id_rak,
            mr.kode_rak,
            mr.nama_rak,
            uc.nama as created_by,
            uu.nama as updated_by,
            mbr.created_at,
            mbr.updated_at
            from ms_barang_rak mbr
            inner join ms_rak mr on mbr.id_rak = mr.id_rak
            inner join users uc on uc.id_user = mbr.created_by
            inner join users uu on uu.id_user = mbr.updated_by
            where mbr.id_barang = ?
        ',[request()->id_barang]);
    }
    
    public function by_id_rak(){
        return DB::select('
            select  mbr.id_barang_rak,
            mbr.id_barang,
            mbr.id_rak,
            m.barcode,
            m.kode_barang,
            m.nama_barang,
            uc.nama as created_by,
            uu.nama as updated_by,
            mbr.created_at,
            mbr.updated_at
            from ms_barang_rak mbr
            inner join ms_barang m on mbr.id_barang = m.id_barang
            inner join users uc on uc.id_user = mbr.created_by
            inner join users uu on uu.id_user = mbr.updated_by
            where mbr.id_rak = ?
        ',[request()->id_rak]);
    }
}
