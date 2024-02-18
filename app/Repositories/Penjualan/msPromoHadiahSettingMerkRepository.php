<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoHadiahSettingMerk;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoHadiahSettingMerkRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoHadiahSettingMerk());
    }
    
    public function by_id_promo_hadiah()
    {
        return DB::select("
            select
            mphsm.id_promo_hadiah_setting_merk,
            mm.id_merk,
            mm.merk
            from ms_promo_hadiah_setting_merk mphsm
            inner join ms_merk mm on mphsm.id_merk = mm.id_merk
            where mphsm.id_promo_hadiah = ?;
        ",[request()->id_promo_hadiah]);
    }
}
