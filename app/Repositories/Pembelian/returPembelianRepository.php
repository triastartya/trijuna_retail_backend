<?php

namespace App\Repositories\Pembelian;

use App\Helpers\QueryHelper;
use App\Models\Pembelian\trReturPembelian;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class returPembelianRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trReturPembelian());
    }
    
    public function by_param()
    {
        return QueryHelper::queryParam("
            select trp.id_retur_pembelian,
            trp.mekanisme,
            CASE 
            WHEN trp.mekanisme=1 THEN 'potong tagihan'
            ELSE 'tukar barang'
            END as mekanisme_keterangan,
            trp.nomor_retur_pembelian,
            trp.tanggal_retur_pembelian,
            trp.id_warehouse,
            mw.warehouse,
            trp.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            trp.mekanisme,
            trp.total_harga,
            trp.qty,
            trp.status_retur,
            trp.is_deleted,
            ud.nama as deleted_by,
            trp.deleted_at,
            trp.deleted_reason,
            uc.nama as created_by,
            uu.nama as updated_by,
            trp.created_at,
            trp.updated_at
         from tr_retur_pembelian trp
         inner join ms_supplier ms on trp.id_supplier = ms.id_supplier
         inner join ms_warehouse mw on trp.id_warehouse = mw.id_warehouse
         inner join users uc on uc.id_user = trp.created_by
         inner join users uu on uu.id_user = trp.updated_by
         left join users ud on ud.id_user = trp.deleted_by 
        ",request());
    }
    
    public function get_by_id(){
        $data = DB::select("
        select 
        trp.id_retur_pembelian,
        trp.mekanisme,
        CASE 
        WHEN trp.mekanisme=1 THEN 'potong tagihan'
        ELSE 'tukar barang'
        END as mekanisme_keterangan,
        trp.nomor_retur_pembelian,
        trp.tanggal_retur_pembelian,
        trp.id_warehouse,
        mw.warehouse,
        trp.id_supplier,
        ms.kode_supplier,
        ms.nama_supplier,
        trp.mekanisme,
        trp.total_harga,
        trp.qty,
        trp.status_retur,
        trp.is_deleted,
        ud.nama as deleted_by,
        trp.deleted_at,
        trp.deleted_reason,
        uc.nama as created_by,
        uu.nama as updated_by,
        trp.created_at,
        trp.updated_at
         from tr_retur_pembelian trp
         inner join ms_supplier ms on trp.id_supplier = ms.id_supplier
         inner join ms_warehouse mw on trp.id_warehouse = mw.id_warehouse
         inner join users uc on uc.id_user = trp.created_by
         inner join users uu on uu.id_user = trp.updated_by
         left join users ud on ud.id_user = trp.deleted_by
            where trp.id_retur_pembelian = ?
        ",[request()->id_retur_pembelian]);
        return $data[0];
    }
    
    public function detail_by_id(){
        return DB::select("
        select
        trpd.id_retur_pembelian_detail,
        trpd.id_retur_pembelian,
        trpd.urut,
        trpd.id_barang,
        mb.barcode,
        mb.kode_barang,
        mb.nama_barang,
        trpd.banyak,
        trpd.kode_satuan,
        ms.nama_satuan,
        trpd.isi,
        trpd.qty,
        trpd.harga_satuan,
        trpd.sub_total,
        trpd.created_at,
        trpd.updated_at
        from tr_retur_pembelian_detail trpd
        inner join ms_barang mb on trpd.id_barang = mb.id_barang
        inner join ms_satuan ms on trpd.kode_satuan = ms.kode_satuan
        where trpd.id_retur_pembelian = ?
        order by trpd.urut
        ",[request()->id_retur_pembelian]);            
    }

    public function belum_lunas_by_param()
    {
        return QueryHelper::queryParam('
            select trp.id_retur_pembelian,
            trp.jenis_retur,
            trp.nomor_retur_pembelian,
            trp.tanggal_retur_pembelian,
            trp.id_warehouse,
            mw.warehouse,
            trp.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            trp.mekanisme,
            trp.total_harga,
            trp.qty,
            trp.status_retur,
            trp.is_deleted,
            ud.nama as deleted_by,
            trp.deleted_at,
            trp.deleted_reason,
            uc.nama as created_by,
            uu.nama as updated_by,
            trp.created_at,
            trp.updated_at
         from tr_retur_pembelian trp
         inner join ms_supplier ms on trp.id_supplier = ms.id_supplier
         inner join ms_warehouse mw on trp.id_warehouse = mw.id_warehouse
         inner join users uc on uc.id_user = trp.created_by
         inner join users uu on uu.id_user = trp.updated_by
         left join users ud on ud.id_user = trp.deleted_by 
         where trp.is_lunas = false
        ',request());
    }
}
