<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoDiskonSettingSupplier;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoDiskonSettingSupplierRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoDiskonSettingSupplier());
    }
    
    public function by_id_promo_diskon()
    {
        return DB::select("
            select
            mpdss.id_promo_diskon_setting_supplier,
            ms.kode_supplier,
            ms.nama_supplier
            from ms_promo_diskon_setting_supplier mpdss
            inner join ms_supplier ms on mpdss.id_supplier = ms.id_supplier
            where mpdss.id_promo_diskon= ?;
        ",[request()->id_promo_diskon]);
    }
}
