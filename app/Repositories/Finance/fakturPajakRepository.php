<?php

namespace App\Repositories\Finance;

use App\Helpers\QueryHelper;
use App\Models\Finance\trFakturPajak;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class fakturPajakRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trFakturPajak());
    }

    public function by_param()
    {
        return QueryHelper::queryParam('
            select
            CASE
                    WHEN tfp.retur = false THEN ms.kode_supplier
                    ELSE msr.kode_supplier
            END AS kode_supplier,
            CASE
                    WHEN tfp.retur = false THEN ms.nama_supplier
                    ELSE msr.nama_supplier
            END AS nama_supplier,
            CASE
                    WHEN tfp.retur = false THEN ms.alamat
                    ELSE msr.alamat
            END AS alamat,
            CASE
                    WHEN tfp.retur = false THEN ms.npwp
                    ELSE msr.npwp
            END AS npwp,
            CASE
                    WHEN tfp.retur = false THEN ms.id_supplier
                    ELSE msr.id_supplier
            END AS id_supplier,
            CASE
                    WHEN tfp.retur = false THEN tp.nomor_penerimaan
                    ELSE trp.nomor_retur_pembelian
            END AS nomor_penerimaan,
            tp.tanggal_nota,
            tfp.id_faktur_pajak,
            tfp.id_penerimaan,
            tfp.dasar_pengenaan_pajak,
            tfp.ppn,
            tfp.no_seri,
            tfp.tanggal_faktur_pajak,
            tfp.nama_ttd_faktur,
            tfp.keterangan,
            tfp.created_at,
            uc.nama as created_by,
            tfp.updated_by,
            uu.nama as updated_by,
            tfp.retur
            from tr_faktur_pajak tfp
            left join tr_penerimaan tp on tfp.id_penerimaan = tp.id_penerimaan
            left join tr_pemesanan tps on tp.id_pemesanan =tps.id_pemesanan
            left join ms_supplier ms on tps.id_supplier = ms.id_supplier
            inner join users uc on uc.id_user = tfp.created_by
            inner join users uu on uu.id_user = tfp.updated_by
            left join tr_retur_pembelian trp on trp.id_retur_pembelian=tfp.id_penerimaan
            left join ms_supplier msr on msr.id_supplier=trp.id_supplier
        ',request());
    }

    public function get_by_id(){
        $data = DB::select("
            select
            CASE
                WHEN tfp.retur = false THEN ms.kode_supplier
                ELSE msr.kode_supplier
            END AS kode_supplier,
            CASE
                    WHEN tfp.retur = false THEN ms.nama_supplier
                    ELSE msr.nama_supplier
            END AS nama_supplier,
            CASE
                    WHEN tfp.retur = false THEN ms.alamat
                    ELSE msr.alamat
            END AS alamat,
            CASE
                    WHEN tfp.retur = false THEN ms.npwp
                    ELSE msr.npwp
            END AS npwp,
            CASE
                    WHEN tfp.retur = false THEN ms.id_supplier
                    ELSE msr.id_supplier
            END AS id_supplier,
            CASE
                    WHEN tfp.retur = false THEN tp.nomor_penerimaan
                    ELSE trp.nomor_retur_pembelian
            END AS nomor_penerimaan,
            tp.tanggal_nota,
            tfp.id_faktur_pajak,
            tfp.id_penerimaan,
            tfp.dasar_pengenaan_pajak,
            tfp.ppn,
            tfp.no_seri,
            tfp.tanggal_faktur_pajak,
            tfp.nama_ttd_faktur,
            tfp.keterangan,
            tfp.created_at,
            uc.nama as created_by,
            tfp.updated_by,
            uu.nama as updated_by,
            tfp.retur
            from tr_faktur_pajak tfp
            left join tr_penerimaan tp on tfp.id_penerimaan = tp.id_penerimaan
            left join tr_pemesanan tps on tp.id_pemesanan =tps.id_pemesanan
            left join ms_supplier ms on tps.id_supplier = ms.id_supplier            
            inner join users uc on uc.id_user = tfp.created_by
            inner join users uu on uu.id_user = tfp.updated_by
			left join tr_retur_pembelian trp on trp.id_retur_pembelian=tfp.id_penerimaan
			left join ms_supplier msr on msr.id_supplier=trp.id_supplier
            where tfp.id_faktur_pajak = ?
        ",[request()->id_faktur_pajak]);
        return $data[0];
    }
}
