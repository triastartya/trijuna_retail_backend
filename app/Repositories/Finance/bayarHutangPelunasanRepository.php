<?php

namespace App\Repositories\Finance;

use App\Helpers\QueryHelper;
use App\Models\Finance\trBayarHutangPelunasan;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class bayarHutangPelunasanRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trBayarHutangPelunasan());
    }

    public function get_by_param()
    {
        return QueryHelper::queryParam('
            select
            tbhp.id_bayar_hutang_pelunasan,
            ms.nama_supplier,
            tbhp.nomor_pelunasan,
            tbhp.tanggal_bayar,
            tbhp.jumlah_bayar,
            tbh.nomor_titip_tagihan,
            tbhp.created_by,
            tbhp.updated_by,
            tbhp.created_at,
            uc.nama as created_by,
            tbhp.updated_at,
            uu.nama as updated_by
            from tr_bayar_hutang_pelunasan tbhp
            inner join tr_bayar_hutang tbh on tbhp.id_bayar_hutang=tbh.id_bayar_hutang
            inner join ms_supplier ms on tbh.id_supplier=ms.id_supplier
            inner join users uc on uc.id_user = tbhp.created_by
            inner join users uu on uu.id_user = tbhp.updated_by 
        ',request());
    }

    public function get_by_id(){
        $data = DB::select("
            select
            tbhp.id_bayar_hutang_pelunasan,
            ms.nama_supplier,
            ms.kode_supplier,
            ms.alamat,
            tbhp.nomor_pelunasan,
            tbhp.tanggal_bayar,
            tbhp.jumlah_bayar,
            tbh.nomor_titip_tagihan,
            tbhp.created_by,
            tbhp.updated_by,
            tbhp.created_at,
            uc.nama as created_by,
            tbhp.updated_at,
            uu.nama as updated_by
            from tr_bayar_hutang_pelunasan tbhp
            inner join tr_bayar_hutang tbh on tbhp.id_bayar_hutang=tbh.id_bayar_hutang
            inner join ms_supplier ms on tbh.id_supplier=ms.id_supplier
            inner join users uc on uc.id_user = tbhp.created_by
            inner join users uu on uu.id_user = tbhp.updated_by
            where tbhp.id_bayar_hutang_pelunasan = ?;
        ",[request()->id_bayar_hutang_pelunasan]);
        return $data[0];
    }

    public function get_transfer(){
        $data = DB::select("
            select
            tbhpt.id_bayar_hutang_pelunasan_transfer,
            mro.bank,
            mro.nama_rekening,
            mro.nomor_rekening,
            tbhpt.waktu_bayar,
            tbhpt.nominal_bayar,
            tbhpt.created_at,
            tbhpt.updated_at
            from tr_bayar_hutang_pelunasan_transfer tbhpt
            inner join public.ms_rekening_owner mro on tbhpt.id_rekening = mro.id_rekening
            where tbhpt.id_bayar_hutang_pelunasan = ?;
        ",[request()->id_bayar_hutang_pelunasan]);
        return $data[0];
    }

}
