<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangKomponen;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class barangKomponenRepository extends VierRepository
{
    public $repository_barang_satuan;

    public function __construct()
    {
        parent::__construct(new msBarangKomponen());
        $this->repository_barang_satuan = new barangSatuanRepository();
    }
    
    public function by_id_barang()
    {
        $data =  DB::select('
            select
            mbk.id_barang,
            mbk.id_barang_komponen,
            mb.barcode,
            mb.kode_barang,
            mb.nama_barang,
            mbk.qty_komponen,
            ms.kode_satuan,
            uc.nama as created_by,
            uu.nama as updated_by,
            mbk.created_at,
            mbk.updated_at from ms_barang_komponen mbk
            left join ms_barang mb on mb.id_barang = mbk.komponen_barang
            inner join ms_satuan ms on mb.id_satuan = ms.id_satuan
            inner join users uc on uc.id_user = mbk.created_by
            inner join users uu on uu.id_user = mbk.updated_by
            where mbk.id_barang = ?
        ',[request()->id_barang]);
        return $data;
    }
}
