<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trMutasi;
use App\Repositories\Master\warehouseRepository;
use Viershaka\Vier\VierRepository;
use Illuminate\Support\Facades\DB;

class mutasiRepository extends VierRepository
{
    public $repository_warehouse;

    public function __construct()
    {
        $this->repository_warehouse = new warehouseRepository();
        parent::__construct(new trMutasi());
    }
    public function get_warehouse_by_id_warehouse()
    {
        return DB::select("
                select
                tmw.id_mutasi_warehouse,
                tmw.tanggal_mutasi_warehouse,
                tmw.warehouse_asal,
                tmw.warehouse_tujuan,
                tmw.qty,
                tmw.total_harga,
                tmw.status_mutasi_warehouse,
                tmw.id_barang_stok
                from tr_mutasi_warehouse tmw
                inner join ms_barang_stok mbs on tmw.id_barang_stok = mbs.id_barang_stok
                where tmw.id_mutasi_warehouse = ?
            ",[request()->id_mutasi_warehouse])[0];
    }

    public function get_warehouse_by_param(){
        return QueryHelper::queryParam(
            "select
            tmw.id_mutasi_warehouse,
            tmw.tanggal_mutasi_warehouse,
            tmw.warehouse_asal,
            tmw.warehouse_tujuan,
            tmw.qty,
            tmw.total_harga,
            tmw.status_mutasi_warehouse,
            tmw.id_barang_stok
            from tr_mutasi_warehouse tmw
            inner join ms_barang_stok mbs on tmw.id_barang_stok = mbs.id_barang_stok"
        ,request());
    }
}
