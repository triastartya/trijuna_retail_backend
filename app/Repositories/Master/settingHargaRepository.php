<?php

namespace App\Repositories\Master;

use App\Helpers\QueryHelper;
use App\Models\Master\trSettingHarga;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class settingHargaRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trSettingHarga());
    }
    
    public function by_param()
    {
        return QueryHelper::queryParam('
            select
            tsh.id_setting_harga,
            tsh.id_lokasi,
            ml.nama_lokasi,
            tsh.tanggal_mulai_berlaku,
            uc.nama as created_by,
            uu.nama as updated_by,
            tsh.created_at,
            tsh.updated_at
            from tr_setting_harga tsh
            inner join ms_lokasi ml on ml.id_lokasi = tsh.id_lokasi
            inner join users uc on uc.id_user = tsh.created_by
            inner join users uu on uu.id_user = tsh.updated_by
        ',request());
    }
    
    public function by_id()
    {
        return DB::select('
            select
            tsh.id_setting_harga,
            tsh.id_lokasi,
            ml.nama_lokasi,
            tsh.tanggal_mulai_berlaku,
            uc.nama as created_by,
            uu.nama as updated_by,
            tsh.created_at,
            tsh.updated_at
            from tr_setting_harga tsh
            inner join ms_lokasi ml on ml.id_lokasi = tsh.id_lokasi
            inner join users uc on uc.id_user = tsh.created_by
            inner join users uu on uu.id_user = tsh.updated_by
            where tsh.id_setting_harga = ?
        ',[request()->id_setting_harga])[0];
    }
    
    public function detail_by_id_setting_harga()
    {
        return DB::select('
            select
            tshd.id_setting_harga_detail,
            tshd.tanggal_mulai_berlaku,
            tshd.id_setting_harga,
            tshd.id_barang,
            mb.barcode,
            mb.kode_barang,
            mb.nama_barang,
            tshd.harga_jual,
            tshd.qty_grosir1,
            tshd.harga_grosir1,
            tshd.qty_grosir2,
            tshd.harga_grosir2,
            tshd.prioritas,
            tshd.created_at,
            tshd.updated_at
            from tr_setting_harga_detail tshd
            inner join ms_barang mb on tshd.id_barang = mb.id_barang
            where tshd.id_setting_harga = ?
        ',[request()->id_setting_harga]);
    }
    
    public function detail_lokasi_by_id_setting_harga_detail($id_setting_harga_detail)
    {
        return DB::select('
            select tshdl.id_setting_harga_detail_lokasi,
            tshdl.id_setting_harga_detail,
            tshdl.id_lokasi,
            ml.nama_lokasi,
            tshdl.created_at,
            tshdl.updated_at
            from tr_setting_harga_detail_lokasi tshdl
            inner join ms_lokasi ml on tshdl.id_lokasi = ml.id_lokasi
            where tshdl.id_setting_harga_detail = ?
        ',[$id_setting_harga_detail]);
    }
    
    public function harga_jual_by_id_barang($id_barang)
    {
        $hj =  DB::select('
            select
            tshd.harga_jual,
            tshd.qty_grosir1,
            tshd.harga_grosir1,
            tshd.qty_grosir2,
            tshd.harga_grosir2
            from tr_setting_harga_detail_lokasi tshdl
            inner join tr_setting_harga_detail tshd on tshdl.id_setting_harga_detail = tshd.id_setting_harga_detail
            inner join tr_setting_harga tsh on tshd.id_setting_harga = tsh.id_setting_harga
            where tsh.tanggal_mulai_berlaku <= now()::timestamp and tshdl.id_lokasi = ? and tshd.id_barang = ? order by tsh.tanggal_mulai_berlaku DESC limit 1
        ',[1,$id_barang]);
        
        if(count($hj)){
            return (array)$hj[0];
        }else{
            return [
                "harga_jual" => 0,
                "qty_grosir1" => 0,
                "harga_grosir1" => 0,
                "qty_grosir2" => 0,
                "harga_grosir2" => 0,
            ];
        }
    }
}
