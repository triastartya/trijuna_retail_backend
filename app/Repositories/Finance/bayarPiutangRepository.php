<?php

namespace App\Repositories\Finance;

use App\Helpers\QueryHelper;
use App\Models\Finance\trBayarPiutang;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class bayarPiutangRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trBayarPiutang());
    }

    public function get_by_id(){
        $data = DB::select("
            select tbp.id_bayar_piutang,
            tbp.tanggal_bayar,
            tbp.id_member,
            mm.kode_member,
            mm.nama_member,
            tbp.nomor_bayar_piutang,
            tbp.total_bayar_piutang,
            tbp.keterangan,
            tbp.created_by,
            uc.nama as created_by,
            tbp.updated_by,
            uu.nama as updated_by,
            tbp.created_at,
            tbp.updated_at
            from tr_bayar_piutang tbp
            inner join ms_member mm on tbp.id_member = mm.id_member
            inner join users uc on uc.id_user = tbp.created_by
            inner join users uu on uu.id_user = tbp.updated_by
            where id_bayar_piutang = ?;
        ",[request()->id_bayar_piutang]);
        return $data[0];
    }

    public function get_by_param()
    {
        return QueryHelper::queryParam('
            select tbp.id_bayar_piutang,
            tbp.tanggal_bayar,
            tbp.id_member,
            mm.kode_member,
            mm.nama_member,
            tbp.nomor_bayar_piutang,
            tbp.total_bayar_piutang,
            tbp.keterangan,
            tbp.created_by,
            uc.nama as created_by,
            tbp.updated_by,
            uu.nama as updated_by,
            tbp.created_at,
            tbp.updated_at
            from tr_bayar_piutang tbp
            inner join ms_member mm on tbp.id_member = mm.id_member
            inner join users uc on uc.id_user = tbp.created_by
            inner join users uu on uu.id_user = tbp.updated_by 
        ',request());
    }

    public function detail_nota()
    {
        $data = DB::select("
            select
            tbpn.id_bayar_piutang_nota,
            tbpn.id_bayar_piutang,
            tbpn.id_penjualan,
            pp.nota_penjualan,
            pp.tanggal_penjualan,
            pp.total_transaksi2 as nominal,
            tbpn.created_at,
            tbpn.updated_at
            from tr_bayar_piutang_nota tbpn
            inner join public.pos_penjualan pp on tbpn.id_penjualan = pp.id_penjualan
            where tbpn.id_bayar_piutang = ? ",[request()->id_bayar_piutang]);
        return $data[0];
    }

    public function detail_payment()
    {
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
        ",[request()->id_bayar_piutang]);            
    }
}