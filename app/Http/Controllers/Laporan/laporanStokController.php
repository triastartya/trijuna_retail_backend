<?php

namespace App\Http\Controllers\Laporan;

use App\Helpers\QueryHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\msBarangKartuStok;
use App\Repositories\Master\barangRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class laporanStokController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new barangRepository();
        parent::__construct($this->repository);
    }

    public function stok_capture(){
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
            mb.updated_at,
            mb.harga_jual,
            mb.qty_grosir1,
            mb.harga_grosir1,
            mb.qty_grosir2,
            mb.harga_grosir2
            from ms_barang mb
            left join ms_divisi md on mb.id_divisi = md.id_divisi
            left join ms_group mg on mb.id_group = mg.id_group
            left join ms_merk mm on mb.id_merk = mm.id_merk
            left join ms_supplier ms on mb.id_supplier = ms.id_supplier
            left join ms_satuan m on mb.kode_satuan = m.kode_satuan
            inner join users uc on uc.id_user = mb.created_by
            inner join users uu on uu.id_user = mb.updated_by
        ',request(),'limit 10');
        foreach($data as $index => $row){
            $stock_capture_toko = msBarangKartuStok::where('id_barang',$row->id_barang)
                ->where('id_warehouse',2)
                ->where('created_at','<=',request()->tanggal_capture)
                ->orderBy('created_at', 'desc')
                ->first();
            $stock_capture_gudang = msBarangKartuStok::where('id_barang',$row->id_barang)
                ->where('id_warehouse',1)
                ->where('created_at','<=',request()->tanggal_capture)
                ->orderBy('created_at', 'desc')
                ->first();
            $data[$index] = (object) array_merge((array)$row,
            [
                "stok_toko" => ($stock_capture_toko)?$stock_capture_toko->stok_akhir:0,
                "stok_gudang" => ($stock_capture_gudang)?$stock_capture_gudang->stok_akhir:0,
            ]);
        }
        return response()->json(['success'=>true,'data'=>$data]);
    }
}