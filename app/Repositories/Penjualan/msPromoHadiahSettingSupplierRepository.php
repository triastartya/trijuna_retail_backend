<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoHadiahSettingSupplier;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoHadiahSettingSupplierRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoHadiahSettingSupplier());
    }
    
    public function by_id_promo_hadiah()
    {
        return DB::select("
            select
            mphss.id_promo_hadiah_setting_supplier,
            ms.kode_supplier,
            ms.nama_supplier
            from ms_promo_hadiah_setting_supplier mphss
            inner join ms_supplier ms on mphss.id_supplier = ms.id_supplier
            where mphss.id_promo_hadiah= ?;
        ",[request()->id_promo_hadiah]);
    }
}
