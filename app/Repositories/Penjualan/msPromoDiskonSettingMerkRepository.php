<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoDiskonSettingMerk;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoDiskonSettingMerkRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoDiskonSettingMerk());
    }
    
    public function by_id_promo_diskon()
    {
        return DB::select("
            select
            mpdsm.id_promo_diskon_setting_merk,
            mm.id_merk,
            mm.merk
            from ms_promo_diskon_setting_merk mpdsm
            inner join ms_merk mm on mpdsm.id_merk = mm.id_merk
            where mpdsm.id_promo_diskon = ?;
        ",[request()->id_promo_diskon]);
    }
    
}
