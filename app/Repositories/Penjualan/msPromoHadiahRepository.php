<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoHadiah;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class msPromoHadiahRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoHadiah());
    }

    public function get_from_pos($id_barang,$id_merk,$id_supplier)
    {
        $hj =  DB::select('
            select * from (
            select distinct mpd.id_promo_hadiah, mpd.is_kelipatan as is_kelipatan_hadiah, mpd.jumlah as minimal_qty_hadiah, mpd.hadiah, mpd.tanggal_mulai as tgl from ms_promo_hadiah_setting_barang mpdsb
            inner join ms_promo_hadiah mpd on mpdsb.id_promo_hadiah=mpd.id_promo_hadiah
            where mpd.tanggal_mulai <= now() and mpd.tanggal_berakhir >= now() and mpdsb.id_barang = ?
            union
            select distinct mpd.id_promo_hadiah, mpd.is_kelipatan as is_kelipatan_hadiah, mpd.jumlah as minimal_qty_hadiah, mpd.hadiah, mpd.tanggal_mulai as tgl from ms_promo_hadiah_setting_merk mpdsm
            inner join ms_promo_hadiah mpd on mpdsm.id_promo_hadiah=mpd.id_promo_hadiah
            where mpd.tanggal_mulai <= now() and mpd.tanggal_berakhir >= now() and mpdsm.id_merk = ?
            union
            select distinct mpd.id_promo_hadiah, mpd.is_kelipatan as is_kelipatan_hadiah, mpd.jumlah as minimal_qty_hadiah, mpd.hadiah, mpd.tanggal_mulai as tgl from ms_promo_hadiah_setting_supplier mpdss
            inner join ms_promo_hadiah mpd on mpdss.id_promo_hadiah=mpd.id_promo_hadiah
            where mpd.tanggal_mulai <= now() and mpd.tanggal_berakhir >= now() and mpdss.id_supplier = ?
            ) as tbl order by tgl limit 1
        ',[$id_barang,$id_merk,$id_supplier]);
        
        if(count($hj)){
            return (array)$hj[0];
        }else{
            return [
                "id_promo_hadiah" => 0,
                "is_kelipatan_hadiah" => false,
                "minimal_qty_hadiah"=>0,
                "hadiah" => "",
                "tgl" => 0
            ];
        }
    }
}
