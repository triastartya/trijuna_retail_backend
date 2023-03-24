<?php

namespace App\Repositories\Master;

use App\Helpers\QueryHelper;
use App\Models\Master\msBarang;
use Viershaka\Vier\VierRepository;

class barangRepository extends VierRepository
{

    public $repository_setting_harga;
    
    public function __construct()
    {
        $this->repository_setting_harga =  new settingHargaRepository();
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
            inner join ms_divisi md on mb.id_divisi = md.id_divisi
            inner join ms_group mg on mb.id_group = mg.id_group
            inner join ms_merk mm on mb.id_merk = mm.id_merk
            inner join ms_supplier ms on mb.id_supplier = ms.id_supplier
            inner join ms_satuan m on mb.id_satuan = m.id_satuan
            inner join users uc on uc.id_user = mb.created_by
            inner join users uu on uu.id_user = mb.updated_by
        ',request(),'limit 200');
        
        foreach($data as $index => $row){
            $data[$index] = (object) array_merge((array)$row,$this->repository_setting_harga->harga_jual_by_id_barang($row->id_barang));
        }
        
        return $data;
        
    }
    
    public function by_param_active(){
        return QueryHelper::queryParam('
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
            inner join ms_divisi md on mb.id_divisi = md.id_divisi
            inner join ms_group mg on mb.id_group = mg.id_group
            inner join ms_merk mm on mb.id_merk = mm.id_merk
            inner join ms_supplier ms on mb.id_supplier = ms.id_supplier
            inner join ms_satuan m on mb.id_satuan = m.id_satuan
            inner join users uc on uc.id_user = mb.created_by
            inner join users uu on uu.id_user = mb.updated_by 
            where mb.is_active = true 
        ',request(),'limit 200');
    }
}
