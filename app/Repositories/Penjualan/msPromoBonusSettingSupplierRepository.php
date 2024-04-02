<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoBonusSettingSupplier;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoBonusSettingSupplierRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoBonusSettingSupplier());
    }

    public function by_id_promo_bonus()
    {
        return DB::select("
            select *
            from ms_promo_bonus_supplier
            where id_promo_bonus = ?;
        ",[request()->id_promo_bonus]);
    }
}
