<?php

namespace App\Repositories\Finance;

use App\Helpers\QueryHelper;
use App\Models\Finance\trBayarHutang;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class bayarHutangRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trBayarHutang());
    }

    public function penerimaan_belum_lunas()
    {
        return QueryHelper::queryParam('
            select
            tp.id_penerimaan,
            tp.jenis_penerimaan,
            tp.id_pemesanan,
            t.nomor_pemesanan,
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
            from tr_penerimaan tp
            inner join ms_lokasi ml on ml.id_lokasi=tp.id_lokasi
            inner join ms_warehouse mw on mw.id_warehouse=tp.id_warehouse
            inner join tr_pemesanan t on tp.id_pemesanan = t.id_pemesanan
            inner join ms_supplier ms on t.id_supplier = ms.id_supplier
            where tp.is_lunas = false
        ',request());
    }

    public function get_by_param()
    {
        return QueryHelper::queryParam('
            select tbh.id_bayar_hutang,
            tbh.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            tbh.nomor_titip_tagihan,
            tbh.tanggal_titip_tagihan,
            tbh.tanggal_rencana_bayar,
            tbh.keterangan,
            tbh.total_titip_tagihan,
            tbh.total_potongan,
            tbh.total_bayar,
            tbh.is_lunas,
            tbh.tanggal_lunas,
            tbh.created_by,
            tbh.updated_by,
            tbh.created_at,
            uc.nama as created_by,
            tbh.updated_at,
            uu.nama as updated_by
            from tr_bayar_hutang tbh
            inner join ms_supplier ms on tbh.id_supplier = ms.id_supplier
            inner join users uc on uc.id_user = tbh.created_by
            inner join users uu on uu.id_user = tbh.updated_by 
        ',request());
    }

    public function get_by_id(){
        $data = DB::select("
            select tbh.id_bayar_hutang,
            tbh.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            tbh.nomor_titip_tagihan,
            tbh.tanggal_titip_tagihan,
            tbh.tanggal_rencana_bayar,
            tbh.keterangan,
            tbh.total_titip_tagihan,
            tbh.total_potongan,
            tbh.total_bayar,
            tbh.is_lunas,
            tbh.tanggal_lunas,
            tbh.created_by,
            tbh.updated_by,
            tbh.created_at,
            uc.nama as created_by,
            tbh.updated_at,
            uu.nama as updated_by
            from tr_bayar_hutang tbh
            inner join ms_supplier ms on tbh.id_supplier = ms.id_supplier
            inner join users uc on uc.id_user = tbh.created_by
            inner join users uu on uu.id_user = tbh.updated_by
            where id_bayar_hutang = ?;
        ",[request()->id_bayar_hutang]);
        return $data[0];
    }
    
    public function detail_faktur_by_id(){
        return DB::select("
            select
            tp.id_pemesanan,
            tp.id_supplier,
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
            tp.updated_by
            from tr_pemesanan tp
            inner join ms_lokasi ml on tp.id_lokasi = ml.id_lokasi
            inner join ms_warehouse mw on tp.id_warehouse = mw.id_warehouse
            inner join tr_bayar_hutang_faktur tbhf on tbhf.id_penerimaan = tp.id_pemesanan
            where tbhf.id_bayar_hutang = ?
        ",[request()->id_bayar_hutang]);            
    }

    public function detail_potongan_by_id(){
        return DB::select("
            select trp.id_retur_pembelian,
            trp.jenis_retur,
            trp.nomor_retur_pembelian,
            trp.tanggal_retur_pembelian,
            trp.id_warehouse,
            mw.warehouse,
            trp.id_supplier,
            trp.mekanisme,
            trp.total_harga,
            trp.qty,
            trp.status_retur,
            trp.is_deleted,
            trp.deleted_at,
            trp.deleted_reason,
            trp.created_at,
            trp.updated_at
            from tr_retur_pembelian trp
            inner join ms_warehouse mw on trp.id_warehouse = mw.id_warehouse
            inner join tr_bayar_hutang_potongan tbhp on tbhp.id_retur_pembelian=trp.id_retur_pembelian
            where id_bayar_hutang = ?;
        ",[request()->id_bayar_hutang]);            
    }

    public function detail_payment_by_id(){
        return DB::select("
            select tbhp.id_bayar_hutang_payment,
            tbhp.id_bayar_hutang,
            tbhp.tanggal_bayar_hutang,
            tbhp.cara_bayar,
            tbhp.id_rekening_pengirim,
            tbhp.no_rekening_pengirim,
            tbhp.bank_pengirim,
            tbhp.atas_nama_pengirim,
            tbhp.id_rekening_penerima,
            tbhp.no_rekening_penerima,
            tbhp.bank_penerima,
            tbhp.atas_nama_penerima,
            tbhp.keterangan,
            tbhp.total_bayar,
            tbhp.created_at,
            tbhp.updated_at
            from tr_bayar_hutang_payment tbhp
            where tbhp.id_bayar_hutang = ?;
        ",[request()->id_bayar_hutang]);            
    }

}
