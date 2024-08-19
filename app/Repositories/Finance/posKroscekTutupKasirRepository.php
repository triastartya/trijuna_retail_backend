<?php

namespace App\Repositories\Finance;

use App\Helpers\QueryHelper;
use Viershaka\Vier\VierRepository;
use App\Models\Finance\posKroscekTutupKasir;
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
}
