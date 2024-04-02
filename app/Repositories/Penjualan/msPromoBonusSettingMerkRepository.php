<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoBonusSettingMerk;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoBonusSettingMerkRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoBonusSettingMerk());
    }
    
    public function by_id_promo_bonus()
    {
        return DB::select("
            select *
            from ms_promo_bonus_merk
            where id_promo_bonus = ?;
        ",[request()->id_promo_bonus]);
    }
}
