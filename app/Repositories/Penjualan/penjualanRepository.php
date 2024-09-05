<?php

namespace App\Repositories\Penjualan;

use App\Helpers\QueryHelper;
use App\Models\Penjualan\posPenjualan;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class penjualanRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posPenjualan());
    }
    
    public function get_by_id(){
        $data =  DB::select("
        select pp.id_penjualan,
        pp.id_user_kasir,
        uk.nama as nama_kasir,
        pp.is_bayar,
        pp.tanggal_penjualan,
        pp.nota_penjualan,
        pp.id_member,
        mm.nomor_identitas,
        mm.nama_member,
        mm.kode_member,
        mm.alamat,
        mm.no_handphone,
        pp.total_diskon_dalam,
        pp.total_transaksi,
        pp.diskon_luar_persen,
        pp.diskon_luar_nominal,
        pp.ongkos_kirim,
        pp.pembulatan,
        pp.total_transaksi2,
        pp.total_bayar,
        pp.kembali,
        pp.biaya_bank,
        pp.is_using_voucher,
        pp.id_pos_kasir,
        pp.id_tutup_kasir,
        pp.is_deleted,
        pp.deleted_at,
        pp.deleted_reason,
        ud.nama as deleted_by,
        pp.deleted_at,
        pp.deleted_reason,
        uc.nama as created_by,
        pp.created_at,
        uu.nama as updated_by,
        pp.updated_at
        from pos_penjualan pp
        inner join users uk on uk.id_user = pp.id_user_kasir
        inner join users uc on uc.id_user = pp.created_by
        inner join users uu on uu.id_user = pp.updated_by
        left join ms_member mm on pp.id_member = mm.id_member
        left join users ud on ud.id_user = pp.deleted_by
        where pp.id_penjualan = ?
        ",[request()->id_penjualan]);
        return $data[0];
    }
    
    public function by_param(){
        return QueryHelper::queryParam("
            select pp.id_penjualan,
            pp.id_user_kasir,
            uk.nama as nama_kasir,
            pp.is_bayar,
            pp.tanggal_penjualan,
            pp.no_faktur as nota_penjualan,
            pp.id_member,
            mm.nomor_identitas,
            mm.nama_member,
            mm.kode_member,
            mm.alamat,
            mm.no_handphone,
            pp.total_diskon_dalam,
            pp.total_transaksi,
            pp.diskon_luar_persen,
            pp.diskon_luar_nominal,
            pp.ongkos_kirim,
            pp.pembulatan,
            pp.total_transaksi2,
            pp.total_bayar,
            pp.kembali,
            pp.biaya_bank,
            pp.is_using_voucher,
            pp.id_pos_kasir,
            pp.id_tutup_kasir,
            pp.is_deleted,
            pp.deleted_at,
            pp.deleted_reason,
            ud.nama as deleted_by,
            pp.deleted_at,
            pp.deleted_reason,
            uc.nama as created_by,
            pp.created_at,
            uu.nama as updated_by,
            pp.updated_at
            from pos_penjualan pp
            inner join users uk on uk.id_user = pp.id_user_kasir
            inner join users uc on uc.id_user = pp.created_by
            inner join users uu on uu.id_user = pp.updated_by
            left join ms_member mm on pp.id_member = mm.id_member
            left join users ud on ud.id_user = pp.deleted_by
            where is_deleted = false 
        ",request());
    }

    public function belum_lunas(){
        return QueryHelper::queryParam("
            select
            pp.nota_penjualan,
            pp.tanggal_penjualan,
            pp.total_transaksi2 as nominal
            from public.pos_penjualan pp
            where pp.id_member = ?
        ",request());
    }
    
    public function get_detail(){
        return DB::select("
            select
            trd.id_penjualan,
            trd.id_penjualan_detail,
            trd.urut,
            trd.id_barang,
            mb.barcode,
            mb.nama_barang,
            trd.kode_satuan,
            trd.harga_jual,
            trd.diskon1,
            trd.diskon2,
            trd.display_diskon1,
            trd.display_diskon2,
            trd.sub_total
            from pos_penjualan_detail trd
            inner join ms_barang mb on trd.id_barang = mb.id_barang
            where trd.id_penjualan = ?
            order by urut
        ",[request()->id_penjualan]);            
    }

    public function get_omzet_barang_by_month(){
        $month=date('m');
        $year=date('Y');
        return DB::select("
            select
            SUM(trd.qty_jual) as qty_jual
            from pos_penjualan_detail trd
            inner join pos_penjualan pp on trd.id_penjualan=pp.id_penjualan
            where trd.id_barang = ? 
            and EXTRACT(MONTH from tanggal_penjualan)=?
            and EXTRACT(YEAR from tanggal_penjualan)=?;
        ",[request()->id_barang,$month,$year]);            
    }

    public function get_mozet_last_3_month(){
        return DB::select("
            select substr(month_year::varchar,0,8) as tanggal,qty_jual as qty,harga_jual as nominal from (
            select DATE_TRUNC('month', pp.tanggal_penjualan) AS month_year,
            SUM(trd.qty_jual)                         as qty_jual,
            sum(trd.harga_jual)                       as harga_jual
            from pos_penjualan_detail trd
            inner join pos_penjualan pp on trd.id_penjualan = pp.id_penjualan
            where id_barang = ?
            AND pp.tanggal_penjualan BETWEEN (CURRENT_DATE - INTERVAL '3 months') AND CURRENT_DATE
            GROUP BY month_year, trd.id_barang
            ORDER BY
            month_year desc) as tbl;",[request()->id_barang]);
    }
    
    public function get_payment(){
        return DB::select("
        select ppp.id_penjualan_peyment,
        ppp.id_penjualan,
        ppp.urut,
        ppp.jenis_pembayar,
        ppp.jumlah_bayar,
        ppp.keterangan,
        ppp.id_voucher,
        ppp.id_payment_method,
        ppm.nama_payment_method,
        ppp.id_bank,
        pb.nama_bank,
        ppp.id_edc,
        pe.nama_edc,
        ppp.trace_number,
        ppp.jenis_kartu,
        ppp.card_holder,
        ppp.tanggal_jatuh_tempo_piutang,
        ppp.keterangan_piutang,
        ppp.created_at,
        ppp.updated_at
             from pos_penjualan_peyment ppp
             inner join pos_payment_method ppm on ppp.id_payment_method = ppm.id_payment_method
             left join pos_bank pb on ppp.id_bank = pb.id_bank
             left join pos_edc pe on ppp.id_edc = pe.id_edc
            where ppp.id_penjualan = ?
            order by ppp.urut
        ",[request()->id_penjualan]);            
    }

    public function sell_out_item(){
        return QueryHelper::queryParam("
        select
        mb.kode_barang,
        mb.barcode,
        mb.nama_barang,
        mb.id_barang,
        mb.id_divisi,
        md.divisi,
        mb.id_group,
        mg.group,
        mb.kode_satuan,
        mb.id_merk,
        mm.merk,
        sum(ppd.qty_jual)  qty_jual,
        sum(ppd.harga_jual) as harga_jual,
        sum(ppd.qty_jual) * sum(ppd.harga_jual) as subtotal
        from pos_penjualan pp
        inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
        inner join ms_barang mb on mb.id_barang = ppd.id_barang
        left join ms_group mg on mg.id_group = mb.id_group
        left join ms_divisi md on md.id_divisi=mb.id_satuan
        left join  ms_merk mm on mm.id_merk=mb.id_merk
        where (pp.tanggal_penjualan BETWEEN '".request()->start."' and '".request()->end."')",
        request(),
        '
        group by
        mb.kode_barang,
        mb.barcode,
        mb.nama_barang,
        mb.id_barang,
        mb.id_divisi,
        md.divisi,
        mb.id_group,
        mg.group,
        mb.kode_satuan,
        mb.id_merk,
        mm.merk
        ');
    }
}
