<?php

namespace App\Repositories\Pembelian;

use App\Helpers\QueryHelper;
use Att\Workit\AttRepository;
use Illuminate\Support\Facades\DB;

class pemesananRepository extends AttRepository
{
    public function __construct()
    {
        // parent::__construct(new Model());
    }
    
    public function get_pemesanan_by_id_pemesanan()
    {
        return DB::select("
                select
                tp.id_pemesanan,
                tp.id_supplier,
                ms.kode_supplier,
                ms.nama_supplier,
                ms.alamat,
                tp.nomor_pemesanan,
                tp.tanggal_pemesanan,
                tp.tangal_expired_pemesanan,
                tp.tanggal_kirim,
                tp.id_lokasi,
                ml.nama_lokasi,
                tp.id_warehouse,
                mw.warehouse,
                tp.keterangan,
                tp.status_pemesanan,
                tp.qty,
                tp.sub_total1,
                tp.diskon_persen,
                tp.diskon_nominal,
                tp.sub_total2,
                tp.ppn_nominal,
                tp.total_transaksi,
                tp.created_at,
                uc.nama as created_by,
                tp.updated_by,
                uu.nama as updated_by
                from tr_pemesanan tp
                inner join ms_lokasi ml on tp.id_lokasi = ml.id_lokasi
                inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
                inner join ms_supplier ms on tp.id_supplier = ms.id_supplier
                inner join users uc on uc.id_user = tp.created_by
                inner join users uu on uu.id_user = tp.updated_by
                left join users ud on ud.id_user = tp.deleted_by
                where tp.id_pemesanan = ?
            ",[request()->id_pemesanan])[0];
    }
    
    public function get_pemesanan_detail_by_id_pemesanan(){
        return DB::select("
                select
                tpd.id_pemesanan_detail,
                tpd.id_pemesanan,
                tpd.urut,
                tpd.id_barang,
                mb.barcode,
                mb.kode_barang,
                mb.nama_barang,
                tpd.banyak,
                tpd.banyak_terima,
                tpd.kode_satuan,
                ms.nama_satuan,
                tpd.isi,
                tpd.qty,
                tpd.qty_terima,
                tpd.harga_order,
                tpd.diskon_persen_1,
                tpd.diskon_nominal_1,
                tpd.diskon_persen_2,
                tpd.diskon_nominal_2,
                tpd.diskon_persen_3,
                tpd.diskon_nominal_3,
                tpd.sub_total,
                tpd.qty_bonus,
                tpd.nama_bonus
                from tr_pemesanan_detail tpd
                inner join ms_barang mb on tpd.id_barang = mb.id_barang
                inner join ms_satuan ms on tpd.kode_satuan = ms.kode_satuan
                where tpd.id_pemesanan = ?
                order by urut
            ",[request()->id_pemesanan]);            
    }
    
    public function get_pemesanan_by_param(){
        return QueryHelper::queryParam(
            "select
            tp.id_pemesanan,
            tp.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            ms.alamat,
            tp.nomor_pemesanan,
            tp.tanggal_pemesanan,
            tp.tangal_expired_pemesanan,
            tp.tanggal_kirim,
            tp.id_lokasi,
            ml.nama_lokasi,
            tp.id_warehouse,
            mw.warehouse,
            tp.keterangan,
            tp.status_pemesanan,
            tp.qty,
            tp.sub_total1,
            tp.diskon_persen,
            tp.diskon_nominal,
            tp.sub_total2,
            tp.ppn_nominal,
            tp.total_transaksi,
            tp.created_at,
            uc.nama as created_by,
            tp.updated_by,
            uu.nama as updated_by
            from tr_pemesanan tp
            inner join ms_lokasi ml on tp.id_lokasi = ml.id_lokasi
            inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
            inner join ms_supplier ms on tp.id_supplier = ms.id_supplier
            inner join users uc on uc.id_user = tp.created_by
            inner join users uu on uu.id_user = tp.updated_by
            left join users ud on ud.id_user = tp.deleted_by"
        ,request());
    }
}
