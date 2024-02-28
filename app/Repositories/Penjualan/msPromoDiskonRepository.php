<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoDiskon;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoDiskonRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoDiskon());
    }
    
    public function get_from_pos($id_barang,$id_merk,$id_supplier)
    {
        $hj =  DB::select('
            select * from (
            select distinct mpd.id_promo_diskon, mpd.is_nominal, mpd.minimal_qty, mpd.diskon as promo_diskon, mpd.kuota, mpd.tanggal_mulai from ms_promo_diskon_setting_barang mpdsb
            inner join ms_promo_diskon mpd on mpdsb.id_promo_diskon=mpd.id_promo_diskon
            where mpd.tanggal_mulai <= now() and mpd.tanggal_berakhir >= now() and mpdsb.id_barang = ? 
            union
            select distinct mpd.id_promo_diskon, mpd.is_nominal, mpd.minimal_qty, mpd.diskon as promo_diskon, mpd.kuota, mpd.tanggal_mulai from ms_promo_diskon_setting_merk mpdsm
            inner join ms_promo_diskon mpd on mpdsm.id_promo_diskon=mpd.id_promo_diskon
            where mpd.tanggal_mulai <= now() and mpd.tanggal_berakhir >= now() and mpdsm.id_merk = ? 
            union
            select distinct mpd.id_promo_diskon, mpd.is_nominal, mpd.minimal_qty, mpd.diskon as promo_diskon, mpd.kuota, mpd.tanggal_mulai from ms_promo_diskon_setting_supplier mpdss
            inner join ms_promo_diskon mpd on mpdss.id_promo_diskon=mpd.id_promo_diskon
            where mpd.tanggal_mulai <= now() and mpd.tanggal_berakhir >= now() and mpdss.id_supplier = ? 
            ) as tbl order by tanggal_mulai limit 1
        ',[$id_barang,$id_merk,$id_supplier]);
        
        if(count($hj)){
            return (array)$hj[0];
        }else{
            return [
                "id_promo_diskon" => 0,
                "is_nominal" => 0,
                "minimal_qty"=>0,
                "promo_diskon" => 0,
                "kuota" => 0,
                "tanggal_mulai" => null
            ];
        }
    }
}
