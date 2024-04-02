<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoBonusSettingBarang;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoBonusSettingBarangRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoBonusSettingBarang());
    }

    public function by_id_promo_bonus()
    {
        return DB::select("
            select *
            from ms_promo_bonus_barang
            where id_promo_bonus = ?;
        ",[request()->id_promo_bonus]);
    }
}
