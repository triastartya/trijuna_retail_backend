<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trPemusnahan;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class pemusnahanRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trPemusnahan());
    }
    
    public function get_by_id(){
        $data =  DB::select("
            select 
            tp.id_pemusnahan,
            tp.nomor_pemusnahan,
            tp.tanggal_pemusnahan,
            tp.id_warehouse,
            tp.keterangan,
            tp.total_hpp_avarage,
            tp.status_pemusnahan,
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
            from tr_pemusnahan tp
            inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
            inner join users uc on uc.id_user = tp.created_by
            inner join users uu on uu.id_user = tp.updated_by
            left join users ud on ud.id_user = tp.deleted_by
            where tp.id_pemusnahan = ?
        ",[request()->id_pemusnahan]);
            
        return $data[0];
    }
    
    public function by_param(){
        return QueryHelper::queryParam("
        select 
        tp.id_pemusnahan,
        tp.nomor_pemusnahan,
        tp.tanggal_pemusnahan,
        tp.id_warehouse,
        tp.keterangan,
        tp.total_hpp_avarage,
        tp.status_pemusnahan,
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
        from tr_pemusnahan tp
        inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
        inner join users uc on uc.id_user = tp.created_by
        inner join users uu on uu.id_user = tp.updated_by
        left join users ud on ud.id_user = tp.deleted_by
        ",request());
    }
    
    public function get_detail(){
        return DB::select("
            select
            trd.id_pemusnahan,
            trd.id_pemusnahan_detail,
            trd.urut,
            trd.id_barang,
            mb.nama_barang,
            trd.banyak,
            trd.kode_satuan,
            trd.isi,
            trd.qty,
            trd.hpp_average,
            trd.sub_total
            from tr_pemusnahan_detail trd
            inner join ms_barang mb on trd.id_barang = mb.id_barang
            where trd.id_pemusnahan = ?
            order by urut
        ",[request()->id_pemusnahan]);            
    }
}
