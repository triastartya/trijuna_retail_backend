<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoDiskonSettingBarang;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoDiskonSettingBarangRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoDiskonSettingBarang());
    }
    
    public function by_id_promo_diskon()
    {
        return DB::select("
            select
            mpdsb.id_promo_diskon_setting_barang,
            mb.kode_barang,
            mb.barcode,
            mb.nama_barang,
            mb.image,
            mb.warna
            from ms_promo_diskon_setting_barang mpdsb inner join ms_barang mb on mpdsb.id_barang = mb.id_barang
            where mpdsb.id_promo_diskon = ?;
        ",[request()->id_promo_diskon]);
    }
    
}