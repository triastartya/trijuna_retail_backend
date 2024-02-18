<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoHadiahSettingBarang;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoHadiahSettingBarangRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoHadiahSettingBarang());
    }
    
    public function by_id_promo_hadiah()
    {
        return DB::select("
            select  mphsb.id_promo_hadiah_setting_barang,
            mb.kode_barang,
            mb.barcode,
            mb.nama_barang,
            mb.image,
            mb.warna
            from ms_promo_hadiah_setting_barang mphsb
            inner join ms_barang mb on mphsb.id_barang = mb.id_barang
            where mphsb.id_promo_hadiah= ?;
        ",[request()->id_promo_hadiah]);
    }
}
