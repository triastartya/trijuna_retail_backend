<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trProduksi;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class produksiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trProduksi());
    }
    
    public function get_by_id(){
        $data =  DB::select("
            select tp.id_produksi,
            tp.nomor_produksi,
            tp.tanggal_produksi,
            tp.id_warehouse,
            tp.keterangan,
            tp.id_barang,
            mb.kode_barang,
            mb.barcode,
            mb.nama_barang,
            tp.qty_produksi,
            tp.hpp_avarage_produksi,
            tp.total_hpp_avarage_produksi,
            tp.total_hpp_avarage_komponen,
            tp.status_produksi,
            tp.is_deleted,
            tp.deleted_at,
            tp.deleted_reason,
            ud.nama as deleted_by,
            tp.deleted_at,
            tp.deleted_reason,
            uc.nama as created_by,
            tp.created_at,
            uu.nama as updated_by,
            tp.updated_at
             from tr_produksi tp
             inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
             inner join ms_barang mb on tp.id_barang = mb.id_barang
             inner join users uc on uc.id_user = tp.created_by
             inner join users uu on uu.id_user = tp.updated_by
             left join users ud on ud.id_user = tp.deleted_by
            where tp.id_produksi = ?
        ",[request()->id_produksi]);
            
        return $data[0];
    }
    
    public function by_param(){
        return QueryHelper::queryParam("
        select tp.id_produksi,
        tp.nomor_produksi,
        tp.tanggal_produksi,
        tp.id_warehouse,
        tp.keterangan,
        tp.id_barang,
        mb.kode_barang,
        mb.barcode,
        mb.nama_barang,
        tp.qty_produksi,
        tp.hpp_avarage_produksi,
        tp.total_hpp_avarage_produksi,
        tp.total_hpp_avarage_komponen,
        tp.status_produksi,
        tp.is_deleted,
        tp.deleted_at,
        tp.deleted_reason,
        ud.nama as deleted_by,
        tp.deleted_at,
        tp.deleted_reason,
        uc.nama as created_by,
        tp.created_at,
        uu.nama as updated_by,
        tp.updated_at
         from tr_produksi tp
         inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
         inner join ms_barang mb on tp.id_barang = mb.id_barang
         inner join users uc on uc.id_user = tp.created_by
         inner join users uu on uu.id_user = tp.updated_by
         left join users ud on ud.id_user = tp.deleted_by
        ",request());
    }
    
    public function get_detail(){
        return DB::select("
            select
            tpd.id_produksi,
            tpd.id_produksi_detail,
            tpd.urut,
            tpd.id_barang,
            mb.nama_barang,
            tpd.kode_satuan,
            tpd.qty,
            tpd.hpp_average,
            tpd.sub_total
            from tr_produksi_detail tpd
            inner join ms_barang mb on tpd.id_barang = mb.id_barang
            where tpd.id_produksi = ?
            order by urut
        ",[request()->id_produksi]);            
    }
}
