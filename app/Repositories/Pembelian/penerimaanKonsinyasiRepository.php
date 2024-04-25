<?php

namespace App\Repositories\Pembelian;

use App\Helpers\QueryHelper;
use App\Models\Pembelian\trPenerimaan;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class penerimaanKonsinyasiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trPenerimaan());
    }
    
    public function by_param()
    {
        return QueryHelper::queryParam('
            select
            tp.id_penerimaan,
            tp.jenis_penerimaan,
            ms.kode_supplier,
            ms.nama_supplier,
            tp.nomor_penerimaan,
            tp.no_nota,
            tp.tanggal_nota,
            tp.id_lokasi,
            ml.nama_lokasi,
            tp.id_warehouse,
            mw.warehouse,
            tp.keterangan,
            tp.status_penerimaan,
            tp.qty,
            tp.sub_total1,
            tp.diskon_persen,
            tp.diskon_nominal,
            tp.sub_total2,
            tp.ppn_nominal,
            tp.pembulatan,
            tp.total_transaksi,
            tp.total_biaya_barcode,
            tp.is_deleted,
            tp.deleted_by,
            tp.deleted_at,
            tp.deleted_reason,
            tp.created_by,
            tp.updated_by,
            tp.created_at,
            tp.updated_at
            from tr_penerimaan_konsinyasi tp
            inner join ms_lokasi ml on ml.id_lokasi=tp.id_lokasi
            inner join ms_warehouse mw on mw.id_warehouse=tp.id_warehouse
            inner join ms_supplier ms on tp.id_supplier = ms.id_supplier
            where tp.jenis_penerimaan = 3 
        ',request());
    }
    
    public function get_by_id(){
        $data = DB::select("
            select
            tp.id_penerimaan,
            tp.jenis_penerimaan,
            ms.kode_supplier,
            ms.nama_supplier,
            tp.nomor_penerimaan,
            tp.no_nota,
            tp.tanggal_nota,
            tp.id_lokasi,
            ml.nama_lokasi,
            tp.id_warehouse,
            mw.warehouse,
            tp.keterangan,
            tp.status_penerimaan,
            tp.qty,
            tp.sub_total1,
            tp.diskon_persen,
            tp.diskon_nominal,
            tp.sub_total2,
            tp.ppn_nominal,
            tp.pembulatan,
            tp.total_transaksi,
            tp.total_biaya_barcode,
            tp.is_deleted,
            tp.deleted_by,
            tp.deleted_at,
            tp.deleted_reason,
            tp.created_by,
            tp.updated_by,
            tp.created_at,
            tp.updated_at
            from tr_penerimaan_konsinyasi tp
            inner join ms_lokasi ml on ml.id_lokasi=tp.id_lokasi
            inner join ms_warehouse mw on mw.id_warehouse=tp.id_warehouse
            inner join ms_supplier ms on tp.id_supplier = ms.id_supplier
            where tp.id_penerimaan = ?
        ",[request()->id_penerimaan]);
        return $data[0];
    }
    
    public function detail_by_id_penerimaan(){
        return DB::select("
            select
            tpd.id_penerimaan_detail,
            tpd.id_penerimaan,
            tpd.urut,
            tpd.id_barang,
            mb.barcode,
            mb.kode_barang,
            mb.nama_barang,
            tpd.banyak,
            tpd.kode_satuan,
            ms.nama_satuan,
            tpd.isi,
            tpd.qty,
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
            from tr_penerimaan_konsinyasi_detail tpd
            inner join ms_barang mb on tpd.id_barang = mb.id_barang
            inner join ms_satuan ms on tpd.kode_satuan = ms.kode_satuan
            where tpd.id_penerimaan = ?
            order by urut
        ",[request()->id_penerimaan]);            
    }
}
