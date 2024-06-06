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
        inner join users uu on uu.id_user = ptk.updated_by
        left join users ud on ud.id_user = ptk.deleted_by
        inner join users uc on uc.id_user = ptk.created_by
        ",request());
    }
}
