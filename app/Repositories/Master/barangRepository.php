<?php

namespace App\Repositories\Master;

use App\Helpers\QueryHelper;
use App\Http\Controllers\Penjualan\msPromoHadianController;
use App\Models\Master\msBarang;
use App\Models\Penjualan\msPromoDiskon;
use App\Repositories\Penjualan\msPromoDiskonRepository;
use App\Repositories\Penjualan\msPromoHadiahRepository;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class barangRepository extends VierRepository
{

    public $repository_setting_harga;
    public $repository_barang_satuan;
    public $repository_promo_diskon;
    public $repository_promo_hadiah;
    
    public function __construct()
    {
        $this->repository_setting_harga =  new settingHargaRepository();
        $this->repository_barang_satuan = new barangSatuanRepository();
        $this->repository_promo_diskon = new msPromoDiskonRepository();
        $this->repository_promo_hadiah = new msPromoHadiahRepository();
        parent::__construct(new msBarang());
    }
    
    public function by_param(){
        $data =  QueryHelper::queryParam('
            select mb.id_barang,
            mb.id_divisi,
            md.divisi,
            mb.id_group,
            mg.group,
            mb.kode_barang,
            mb.barcode,
            mb.image,
            mb.persediaan,
            mb.nama_barang,
            mb.id_merk,
            mb.ukuran,
            mb.warna,
            mb.berat,
            mb.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            mb.harga_order,
            mb.harga_beli_terakhir,
            mb.hpp_average,
            mb.is_ppn,
            mb.nama_label,
            mb.id_satuan,
            m.kode_satuan,
            m.nama_satuan,
            mb.margin,
            mb.tahun_produksi,
            mb.stok_min,
            mb.is_active,
            uc.nama as created_by,
            mb.created_at,
            uu.nama as updated_by,
            mb.updated_at
            from ms_barang mb
            left join ms_divisi md on mb.id_divisi = md.id_divisi
            left join ms_group mg on mb.id_group = mg.id_group
            left join ms_merk mm on mb.id_merk = mm.id_merk
            left join ms_supplier ms on mb.id_supplier = ms.id_supplier
            left join ms_satuan m on mb.kode_satuan = m.kode_satuan
            inner join users uc on uc.id_user = mb.created_by
            inner join users uu on uu.id_user = mb.updated_by
        ',request(),'limit 200');
        
        foreach($data as $index => $row){
            $data[$index] = (object) array_merge((array)$row,$this->repository_setting_harga->harga_jual_by_id_barang($row->id_barang));
            $data[$index]->satuan = $this->repository_barang_satuan->to_barang_by_param($row->id_barang);
        }
        
        return $data;
        
    }
    
    public function by_param_active(){
        $data = QueryHelper::queryParam('
            select mb.id_barang,
            mb.id_divisi,
            md.divisi,
            mb.id_group,
            mg.group,
            mb.kode_barang,
            mb.barcode,
            mb.image,
            mb.persediaan,
            mb.nama_barang,
            mb.id_merk,
            mb.ukuran,
            mb.warna,
            mb.berat,
            mb.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            mb.harga_order,
            mb.harga_beli_terakhir,
            mb.hpp_average,
            mb.is_ppn,
            mb.nama_label,
            mb.id_satuan,
            m.kode_satuan,
            m.nama_satuan,
            mb.margin,
            mb.tahun_produksi,
            mb.stok_min,
            mb.is_active,
            uc.nama as created_by,
            mb.created_at,
            uu.nama as updated_by,
            mb.updated_at
            from ms_barang mb
            left join ms_divisi md on mb.id_divisi = md.id_divisi
            left join ms_group mg on mb.id_group = mg.id_group
            left join ms_merk mm on mb.id_merk = mm.id_merk
            left join ms_supplier ms on mb.id_supplier = ms.id_supplier
            left join ms_satuan m on mb.kode_satuan = m.kode_satuan
            inner join users uc on uc.id_user = mb.created_by
            inner join users uu on uu.id_user = mb.updated_by 
            where mb.is_active = true 
        ',request(),'limit 200');
        
        foreach($data as $index => $row){
            $data[$index]->satuan = $this->repository_barang_satuan->to_barang_by_param($row->id_barang);
        }
        
        return $data;
    }
    
    public function by_id_wharehouse($id_warehouse){
        $data = QueryHelper::queryParam("
            select mb.id_barang,
            mb.id_divisi,
            md.divisi,
            mb.id_group,
            mg.group,
            mb.kode_barang,
            mb.barcode,
            mb.image,
            mb.persediaan,
            mb.nama_barang,
            mb.id_merk,
            mb.ukuran,
            mb.warna,
            mb.berat,
            mb.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            mb.harga_order,
            mb.harga_beli_terakhir,
            mb.hpp_average,
            mb.is_ppn,
            mb.nama_label,
            mb.id_satuan,
            m.kode_satuan,
            m.nama_satuan,
            mb.margin,
            mb.tahun_produksi,
            mb.stok_min,
            mb.is_active,
            uc.nama as created_by,
            mb.created_at,
            uu.nama as updated_by,
            mb.updated_at,
            mbs.qty,
            mbs.id_warehouse
            from ms_barang mb
            left join ms_divisi md on mb.id_divisi = md.id_divisi
            left join ms_group mg on mb.id_group = mg.id_group
            left join ms_merk mm on mb.id_merk = mm.id_merk
            left join ms_supplier ms on mb.id_supplier = ms.id_supplier
            left join ms_satuan m on mb.kode_satuan = m.kode_satuan
            inner join users uc on uc.id_user = mb.created_by
            inner join users uu on uu.id_user = mb.updated_by
            inner join ms_barang_stok mbs on mb.id_barang = mbs.id_barang
            where mb.is_active = true and id_warehouse = ".$id_warehouse."
        ",request(),'limit 200');
        
        foreach($data as $index => $row){
            $data[$index]->satuan = $this->repository_barang_satuan->to_barang_by_param($row->id_barang);
        }
        
        return $data;
    }

    public function barang_pos(){
        $data =  DB::select('
            select 
            mb.id_merk,
            mb.id_supplier,
            mb.id_barang,
            mb.kode_barang,
            mb.barcode,
            mb.image,
            mb.nama_barang,
            mb.warna,
            m.kode_satuan,
            mb.diskon
            from ms_barang mb
            left join ms_satuan m on mb.kode_satuan = m.kode_satuan
            inner join users uc on uc.id_user = mb.created_by
            inner join users uu on uu.id_user = mb.updated_by
            where mb.is_active = true 
        ');
        
        foreach($data as $index => $row){
            if($row->diskon !=0 AND $row->diskon_mulai != null AND $row->diskon_selesai != null){
                $paymentDate = date('Y-m-d');
                if (($paymentDate >= $row->diskon_mulai) && ($paymentDate <= $row->diskon_selesai)){
    
                }else{
                    $row->diskon = 0;
                }
            }
            $data[$index] = (object) array_merge((array)$data[$index],$this->repository_setting_harga->harga_jual_by_id_barang($row->id_barang),);
            $data[$index] = (object) array_merge((array)$data[$index],$this->repository_promo_diskon->get_from_pos($row->id_barang,$row->id_merk,$row->id_supplier));
            $data[$index] = (object) array_merge((array)$data[$index],$this->repository_promo_hadiah->get_from_pos($row->id_barang,$row->id_merk,$row->id_supplier));
        
        }
        
        return $data;        
    }
}
