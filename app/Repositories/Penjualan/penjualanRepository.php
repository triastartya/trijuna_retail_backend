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
            pp.nota_penjualan,
            pp.id_member,
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
            left join users ud on ud.id_user = pp.deleted_by
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
            trd.id_pos_penjualan_detail,
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
}
