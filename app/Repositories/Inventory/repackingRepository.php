<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trRepacking;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class repackingRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trRepacking());
    }
    
    public function get_by_id(){
        $data =  DB::select("
            select 
            tr.id_repacking,
            tr.nomor_repacking,
            tr.tanggal_repacking,
            tr.id_warehouse,
            tr.keterangan,
            tr.id_barang,
            mb.kode_barang,
            mb.barcode,
            mb.nama_barang,
            tr.qty_repacking,
            tr.hpp_avarage_repacking,
            tr.total_hpp_avarage_urai,
            tr.total_hpp_avarage_repacking,
            tr.status_repacking,
            tr.is_deleted,
            tr.deleted_at,
            tr.deleted_reason,
            ud.nama as deleted_by,
            tr.deleted_at,
            tr.deleted_reason,
            uc.nama as created_by,
            tr.created_at,
            uu.nama as updated_by,
            tr.updated_at
            from tr_repacking tr
            inner join ms_warehouse mw on tr.id_warehouse = mw.id_warehouse
            inner join ms_barang mb on tr.id_barang = mb.id_barang
            inner join users uc on uc.id_user = tr.created_by
            inner join users uu on uu.id_user = tr.updated_by
            left join users ud on ud.id_user = tr.deleted_by
            where tr.id_repacking = ?
        ",[request()->id_repacking]);
            
        return $data[0];
    }
    
    public function by_param(){
        return QueryHelper::queryParam("
            select
            tr.id_repacking,
            tr.nomor_repacking,
            tr.tanggal_repacking,
            tr.id_warehouse,
            tr.keterangan,
            tr.id_barang,
            mb.kode_barang,
            mb.barcode,
            mb.nama_barang,
            tr.qty_repacking,
            tr.hpp_avarage_repacking,
            tr.total_hpp_avarage_urai,
            tr.total_hpp_avarage_repacking,
            tr.status_repacking,
            tr.is_deleted,
            tr.deleted_at,
            tr.deleted_reason,
            ud.nama as deleted_by,
            tr.deleted_at,
            tr.deleted_reason,
            uc.nama as created_by,
            tr.created_at,
            uu.nama as updated_by,
            tr.updated_at
            from tr_repacking tr
            inner join ms_warehouse mw on tr.id_warehouse = mw.id_warehouse
            inner join ms_barang mb on tr.id_barang = mb.id_barang
            inner join users uc on uc.id_user = tr.created_by
            inner join users uu on uu.id_user = tr.updated_by
            left join users ud on ud.id_user = tr.deleted_by
        ",request());
    }
    
    public function get_detail(){
        return DB::select("
            select
            trd.id_repacking,
            trd.id_repacking_detail,
            trd.urut,
            trd.id_barang,
            mb.nama_barang,
            trd.kode_satuan,
            trd.qty,
            trd.hpp_average,
            trd.sub_total
            from tr_repacking_detail trd
            inner join ms_barang mb on trd.id_barang = mb.id_barang
            where trd.id_repacking = ?
            order by urut
        ",[request()->id_repacking]);            
    }
}
