<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoBonusSettingItem;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoBonusSettingItemRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoBonusSettingItem());
    }
    public function by_id_promo_bonus()
    {
        return DB::select("
            select *
            from ms_promo_bonus_item
            where id_promo_bonus = ?;
        ",[request()->id_promo_bonus]);
    }
}
