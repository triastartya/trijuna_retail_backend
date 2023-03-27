<?php

namespace App\Repositories\Pembelian;

use App\Helpers\QueryHelper;
use App\Models\Pembelian\trPenerimaan;
use Viershaka\Vier\VierRepository;

class penerimaanDenganPORepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trPenerimaan());
    }
    
    public function by_param()
    {
        return QueryHelper::queryParam('
            select
            tp.id_penermaan,
            tp.jenis_penerimaan,
            tp.id_pemesanan,
            t.nomor_pemesanan,
            ms.kode_supplier,
            ms.nama_supplier,
            tp.nomor_penerimaan,
            tp.tanggal_penerimaan,
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
            from tr_penerimaan tp
            inner join ms_lokasi ml on ml.id_lokasi=tp.id_lokasi
            inner join ms_warehouse mw on mw.id_warehouse=tp.id_warehouse
            inner join tr_pemesanan t on tp.id_pemesanan = t.id_pemesanan
            inner join ms_supplier ms on t.id_supplier = ms.id_supplier
        ',request());
    }
}
