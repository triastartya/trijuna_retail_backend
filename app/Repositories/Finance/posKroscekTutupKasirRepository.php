<?php

namespace App\Repositories\Finance;

use App\Helpers\QueryHelper;
use Viershaka\Vier\VierRepository;
use App\Models\Finance\posKroscekTutupKasir;
use App\Models\Finance\posTutupKasir;
use Illuminate\Support\Facades\DB;

class posKroscekTutupKasirRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posKroscekTutupKasir());
    }

    public function tutup_kasir_belum_kroscek(){
        return DB::select('
            select ptk.id_tutup_kasir,
                ptk.id_user_kasir,
                uk.nama,
                uk.email,
                ptk.tanggal_tutup_kasir,
                ptk.modal_kasir,
                ptk.pengeluaran,
                ptk.penerimaan,
                ptk.sisa_saldo,
                ptk.keterangan,
                ptk.status_tutup_kasir,
                ptk.id_kroscek_tutup_kasir
                from pos_tutup_kasir ptk
                inner join users uk on ptk.id_user_kasir = uk.id_user
            where ptk.id_kroscek_tutup_kasir is null
            and is_deleted = false;
        ',[]);
    }

    public function by_param(){
        return QueryHelper::queryParam("
            select
            pktk.id_kroscek_tutup_kasir,
            pktk.id_tutup_kasir,
            uk.nama as kasir,
            uk.email,
            ptk.tanggal_tutup_kasir,
            pktk.tanggal_kroscek_tutup_kasir,
            pktk.pendapatan_versi_user,
            pktk.pendapatan_versi_system,
            pktk.selisih,
            pktk.keterangan as keterangan_kroscek,
            ptk.keterangan as keterangan_tutup_kasir,
            uc.nama as created_by,
            pktk.created_at
            from pos_kroscek_tutup_kasir pktk
            inner join pos_tutup_kasir ptk on pktk.id_kroscek_tutup_kasir=ptk.id_kroscek_tutup_kasir
            inner join users uk on uk.id_user = ptk.id_user_kasir
            inner join users uc on uc.id_user = pktk.created_by 
        ",request());
    }

    public function by_id(){
        $data = DB::select('
            select
            pktk.id_kroscek_tutup_kasir,
            pktk.id_tutup_kasir,
            uk.nama as kasir,
            uk.email,
            ptk.tanggal_tutup_kasir,
            pktk.tanggal_kroscek_tutup_kasir,
            pktk.pendapatan_versi_user,
            pktk.pendapatan_versi_system,
            pktk.selisih,
            pktk.keterangan as keterangan_kroscek,
            ptk.keterangan as keterangan_tutup_kasir,
            uc.nama as created_by,
            pktk.created_at
            from pos_kroscek_tutup_kasir pktk
            inner join pos_tutup_kasir ptk on pktk.id_kroscek_tutup_kasir=ptk.id_kroscek_tutup_kasir
            inner join users uk on uk.id_user = ptk.id_user_kasir
            inner join users uc on uc.id_user = pktk.created_by
            where pktk.id_kroscek_tutup_kasir = ?
        ',[request()->id_kroscek_tutup_kasir]);
        return ($data)?$data[0]:null;
    }

    public function detail_by_id(){
        $tutup_kasir = posTutupKasir::where('id_kroscek_tutup_kasir',request()->id_kroscek_tutup_kasir)->first();
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
        ",[$tutup_kasir->id_tutup_kasir]);
    }
}
