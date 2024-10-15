<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trSettingStokOpname;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class trSettingStokOpnameRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new trSettingStokOpname());
    }

    public function get_by_id(){
        $data =  DB::select("
                select id_setting_stok_opname,
                nomor_stok_opname,
                tanggal_setting_stok_opname,
                jenis_stok_opname,
                keterangan,
                total_fisik_harga_jual,
                total_capture_harga_jual,
                total_selisih_harga_jual,
                total_capture_hpp_average,
                total_fisik_hpp_average,
                total_selisih_hpp_average,
                created_by,
                updated_by,
                created_at,
                updated_at,
                status
                from tr_setting_stok_opname
                where id_setting_stok_opname = ?
            ",[request()->id_setting_stok_opname]);
            
        return $data[0];
    }

    public function detail_barang(){
        $data =  DB::select("
                select mb.barcode, mb.kode_barang, mb.nama_barang, mb.kode_satuan
                from tr_setting_stok_opname_barang tssob
                inner join ms_barang mb on tssob.id_barang = mb.id_barang
                where tssob.id_setting_stok_opname = ?
            ",[request()->id_setting_stok_opname]);
            
        return $data;
    }

    public function detail_group(){
        $data =  DB::select('
                select mg.kode_group,mg."group"
                from tr_setting_stok_opname_group tssog
                inner join ms_group mg on tssog.id_group=mg.id_group
                where tssog.id_setting_stok_opname = ?
            ',[request()->id_setting_stok_opname]);
            
        return $data;
    }

    public function detail_divisi(){
        $data =  DB::select("
                select md.kode_divisi,md.divisi
                from tr_setting_stok_opname_divisi tssod
                inner join ms_divisi md on tssod.id_divisi = md.id_divisi
                where tssod.id_setting_stok_opname = ?
            ",[request()->id_setting_stok_opname]);
            
        return $data;
    }

    public function detail_supplier(){
        $data =  DB::select("
               select ms.kode_supplier,ms.nama_supplier,ms.alamat
                from tr_setting_stok_opname_supplier tssos
                inner join ms_supplier ms on tssos.id_supplier=ms.id_supplier
                where tssos.id_setting_stok_opname = ?
            ",[request()->id_setting_stok_opname]);
            
        return $data;
    }

    public function by_param(){
        return QueryHelper::queryParam("
            select id_setting_stok_opname,
            nomor_stok_opname,
            tanggal_setting_stok_opname,
            jenis_stok_opname,
            keterangan,
            status
            from tr_setting_stok_opname
        ",request());
    }
}
