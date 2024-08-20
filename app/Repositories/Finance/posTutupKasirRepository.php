<?php

namespace App\Repositories\Finance;

use Viershaka\Vier\VierRepository;
use App\Models\Finance\posTutupKasir;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;

class posTutupKasirRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posTutupKasir());
    }

    public function history()
    {
        return QueryHelper::queryParam("
        select
            ptk.id_tutup_kasir,
            ptk.id_user_kasir,
            uk.nama as nama_kasir,
            uk.email,
            ptk.tanggal_tutup_kasir,
            ptk.modal_kasir,
            ptk.pengeluaran,
            ptk.penerimaan,
            ptk.sisa_saldo,
            ptk.keterangan,
            ptk.status_tutup_kasir,
            ptk.id_kroscek_tutup_kasir,
            uc.nama as created_by,
            ptk.created_at,
            uu.nama as updated_by,
            ptk.updated_at,
            ptk.is_deleted,
            ud.nama as deleted_by,
            ptk.deleted_at
        from pos_tutup_kasir ptk
        inner join users uk on uk.id_user = ptk.id_user_kasir
        inner join users uu on uu.id_user = ptk.updated_by
        left join users ud on ud.id_user = ptk.deleted_by
        inner join users uc on uc.id_user = ptk.created_by
        ",request());
    }

    public function kasir_belum_closing()
    {
        return DB::select('
            select uk.id_user,uk.nama,uk.email,sum(pmk.modal_kasir) as modal_kasir from pos_modal_kasir pmk
            inner join users uk on pmk.id_user_kasir=uk.id_user
            where pmk.id_tutup_kasir is null and is_deleted = false
            group by uk.nama,uk.email,uk.id_user
        ',[]);
    }

    public function nominal_sistem($id_payment_method)
    {
        $data = DB::select('
            select sum(ppp.jumlah_bayar) as jumlah_bayar
            from pos_penjualan_peyment ppp
            inner join pos_penjualan pp on pp.id_penjualan = ppp.id_penjualan
            where pp.id_tutup_kasir is null and pp.id_user_kasir=? and ppp.id_payment_method=?;
        ',[request()->id_user_kasir,$id_payment_method]);
        return ($data)?$data[0]->jumlah_bayar:0;
    }

    public function kembalian_sistem()
    {
        $data = DB::select('
            select sum(pp.kembali) as kembalian
            from pos_penjualan pp
            where pp.id_tutup_kasir is null and pp.id_user_kasir=?;
        ',[request()->id_user_kasir]);
        return ($data)?$data[0]->kembalian:0;
    }

    public function get_by_id()
    {
        $data =  DB::select("
        select
            ptk.id_tutup_kasir,
            ptk.id_user_kasir,
            uk.nama as nama_kasir,
            uk.email,
            ptk.tanggal_tutup_kasir,
            ptk.modal_kasir,
            ptk.pengeluaran,
            ptk.penerimaan,
            ptk.sisa_saldo,
            ptk.keterangan,
            ptk.status_tutup_kasir,
            ptk.id_kroscek_tutup_kasir,
            uc.nama as created_by,
            ptk.created_at,
            uu.nama as updated_by,
            ptk.updated_at,
            ptk.is_deleted,
            ud.nama as deleted_by,
            ptk.deleted_at
        from pos_tutup_kasir ptk
        inner join users uk on uk.id_user = ptk.id_user_kasir
        inner join users uu on uu.id_user = ptk.updated_by
        left join users ud on ud.id_user = ptk.deleted_by
        inner join users uc on uc.id_user = ptk.created_by
        where ptk.id_tutup_kasir = ?
        ",[request()->id_tutup_kasir]);
        return ($data)?$data[0]:null;
    }

    public function get_detail_penerimaan(){
        return DB::select("
            select
            ppm.id_payment_method,
            ppm.nama_payment_method,
            ptkdp.id_tutup_kasir,
            ptkdp.nominal,
            ptkdp.nominal_sistem,
            ptkdp.selisih
            from pos_tutup_kasir_detail_pendapatan ptkdp
            inner join pos_payment_method ppm on ptkdp.id_payment_method=ppm.id_payment_method
            where ptkdp.id_tutup_kasir = ?
        ",[request()->id_tutup_kasir]);
    }

    
}
