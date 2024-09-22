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
            select ms.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            ms.alamat,
            ms.npwp,
            tp.nomor_penerimaan,
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
            uu.nama as updated_by
            from tr_faktur_pajak tfp
            inner join tr_penerimaan tp on tfp.id_penerimaan = tp.id_penerimaan
            inner join tr_pemesanan tps on tp.id_pemesanan =tps.id_pemesanan
            inner join ms_supplier ms on tps.id_supplier = ms.id_supplier            inner join users uc on uc.id_user = tfp.created_by
            inner join users uu on uu.id_user = tfp.updated_by 
        ',request());
    }

    public function get_by_id(){
        $data = DB::select("
            select ms.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            ms.alamat,
            ms.npwp,
            tp.nomor_penerimaan,
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
            uu.nama as updated_by
            from tr_faktur_pajak tfp
            inner join tr_penerimaan tp on tfp.id_penerimaan = tp.id_penerimaan
            inner join tr_pemesanan tps on tp.id_pemesanan =tps.id_pemesanan
            inner join ms_supplier ms on tps.id_supplier = ms.id_supplier
            inner join users uc on uc.id_user = tfp.created_by
            inner join users uu on uu.id_user = tfp.updated_by
            where tfp.id_faktur_pajak = ?
        ",[request()->id_faktur_pajak]);
        return $data[0];
    }
}
