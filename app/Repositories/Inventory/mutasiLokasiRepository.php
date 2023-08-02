<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trMutasiLokasi;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class mutasiLokasiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trMutasiLokasi());
    }
    
    public function get_by_id(){
        $data =  DB::select("
            select
            tml.id_mutasi_lokasi,
            tml.nomor_mutasi_lokasi,
            tml.tanggal_mutasi_lokasi,
            tml.id_lokasi_asal,
            mla.nama_lokasi as lokasi_asal,
            tml.warehouse_asal,
            mwa.warehouse as nama_warehouse_asal,
            tml.id_lokasi_tujuan,
            mlt.nama_lokasi as lokasi_tujuan,
            tml.warehouse_tujuan,
            mwt.warehouse as nama_warehouse_tujuan,
            tml.qty,
            tml.total_harga,
            tml.status_mutasi_lokasi,
            tml.is_deleted,
            ud.nama as deleted_by,
            tml.deleted_at, 
            tml.deleted_reason,
            uc.nama as created_by,
            tml.created_at,
            uu.nama as updated_by,
            tml.updated_at
            from tr_mutasi_lokasi tml
            inner join ms_lokasi mla on tml.id_lokasi_asal =mla.id_lokasi
            inner join ms_warehouse mwa on tml.warehouse_asal=mwa.id_warehouse
            inner join ms_lokasi mlt on tml.id_lokasi_tujuan =mlt.id_lokasi
            inner join ms_warehouse mwt on tml.warehouse_tujuan=mwt.id_warehouse
            inner join users uc on uc.id_user = tml.created_by
            inner join users uu on uu.id_user = tml.updated_by
            left join users ud on ud.id_user = tml.deleted_by
            where tml.id_mutasi_lokasi = ?
            ",[request()->id_mutasi_lokasi]);
            
        return $data[0];
    }
    
    public function by_param(){
        return QueryHelper::queryParam("
            select
            tml.id_mutasi_lokasi,
            tml.nomor_mutasi_lokasi,
            tml.tanggal_mutasi_lokasi,
            tml.id_lokasi_asal,
            mla.nama_lokasi as lokasi_asal,
            tml.warehouse_asal,
            mwa.warehouse as nama_warehouse_asal,
            tml.id_lokasi_tujuan,
            mlt.nama_lokasi as lokasi_tujuan,
            tml.warehouse_tujuan,
            mwt.warehouse as nama_warehouse_tujuan,
            tml.qty,
            tml.total_harga,
            tml.status_mutasi_lokasi,
            tml.is_deleted,
            ud.nama as deleted_by,
            tml.deleted_at,
            tml.deleted_reason,
            uc.nama as created_by,
            tml.created_at,
            uu.nama as updated_by,
            tml.updated_at
            from tr_mutasi_lokasi tml
            inner join ms_lokasi mla on tml.id_lokasi_asal =mla.id_lokasi
            inner join ms_warehouse mwa on tml.warehouse_asal=mwa.id_warehouse
            inner join ms_lokasi mlt on tml.id_lokasi_tujuan =mlt.id_lokasi
            inner join ms_warehouse mwt on tml.warehouse_tujuan=mwt.id_warehouse
            inner join users uc on uc.id_user = tml.created_by
            inner join users uu on uu.id_user = tml.updated_by
            left join users ud on ud.id_user = tml.deleted_by
        ",request());
    }
    
    public function get_detail(){
        return DB::select("
            select
            tmw.id_mutasi_lokasi,
            tmw.id_mutasi_lokasi_detail,
            tmw.urut,
            tmw.id_barang,
            mb.nama_barang,
            tmw.banyak,
            tmw.kode_satuan,
            tmw.isi,
            tmw.qty,
            tmw.harga_satuan,
            tmw.sub_total
            from tr_mutasi_lokasi_detail tmw
            inner join ms_barang mb on tmw.id_barang = mb.id_barang
            where tmw.id_mutasi_lokasi = ?
            order by urut
        ",[request()->id_mutasi_lokasi]);            
    }
}
