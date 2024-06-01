<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trStokOpname;
use App\Models\Master\msBarang;
use App\Models\Master\msBarangKartuStok;
use App\Repositories\Master\settingHargaRepository;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class stokOpnameRepository extends VierRepository
{
    public $repository_setting_harga;
    public function __construct()
    {
        parent::__construct(new trStokOpname());
        $this->repository_setting_harga =  new settingHargaRepository();
    }

    public function get_by_id(){
        $data =  DB::select("
            select taso.id_audit_stok_opname,
            taso.nomor_audit_stok_opname,
            taso.id_warehouse,
            mw.warehouse,
            taso.id_setting_stok_opname,
            taso.id_group,
            mg.group,
            taso.id_rak,
            mr.nama_rak,
            taso.waktu_capture_stok,
            taso.jumlah_item_fisik,
            taso.total_nominal_fisik,
            taso.jumlah_item_sistem_capture_stok,
            taso.total_nominal_sistem_capture_stok,
            taso.waktu_capture_stok_adj,
            taso.jumlah_item_fisik_adj,
            taso.total_nominal_fisik_adj,
            taso.jumlah_item_sistem_capture_stok_adj,
            taso.total_nominal_sistem_capture_stok_adj,
            taso.jumlah_item_proses_selisih,
            taso.total_nominal_proses_selisih,
            taso.keterangan,
            taso.keterangan_adj,
            taso.keterangan_proses,
            taso.status,
            taso.created_by,
            taso.updated_by,
            taso.created_by_adj,
            taso.created_by_proses,
            taso.created_at,
            taso.updated_at
            from tr_audit_stok_opname taso
            left join ms_warehouse mw on mw.id_warehouse = taso.id_warehouse
            left join ms_group mg on mg.id_group = taso.id_group
            left join public.ms_rak mr on taso.id_rak = mr.id_rak  
            where taso.id_audit_stok_opname = ?
        ",[request()->id_audit_stok_opname]);
            
        return $data[0];
    }
    
    public function by_param(){
        return QueryHelper::queryParam("
            select taso.id_audit_stok_opname,
            taso.nomor_audit_stok_opname,
            taso.id_warehouse,
            mw.warehouse,
            taso.id_setting_stok_opname,
            taso.id_group,
            mg.group,
            taso.id_rak,
            mr.nama_rak,
            taso.waktu_capture_stok,
            taso.jumlah_item_fisik,
            taso.total_nominal_fisik,
            taso.jumlah_item_sistem_capture_stok,
            taso.total_nominal_sistem_capture_stok,
            taso.waktu_capture_stok_adj,
            taso.jumlah_item_fisik_adj,
            taso.total_nominal_fisik_adj,
            taso.jumlah_item_sistem_capture_stok_adj,
            taso.total_nominal_sistem_capture_stok_adj,
            taso.jumlah_item_proses_selisih,
            taso.total_nominal_proses_selisih,
            taso.keterangan,
            taso.keterangan_adj,
            taso.keterangan_proses,
            taso.status,
            taso.created_by,
            taso.updated_by,
            taso.created_by_adj,
            taso.created_by_proses,
            taso.created_at,
            taso.updated_at
            from tr_audit_stok_opname taso
            left join ms_warehouse mw on mw.id_warehouse = taso.id_warehouse
            left join ms_group mg on mg.id_group = taso.id_group
            left join public.ms_rak mr on taso.id_rak = mr.id_rak
        ",request());
    }
    
    public function get_detail(){
        return DB::select("
            select tasod.id_audit_stok_opname_detail,
            tasod.id_audit_stok_opname,
            tasod.no_urut,
            tasod.id_barang,
            mb.kode_barang,
            mb.nama_barang,
            tasod.harga_jual,
            tasod.hpp_avarage,
            tasod.waktu_capture_stok,
            tasod.qty_fisik,
            tasod.qty_sistem_capture_stok,
            tasod.sub_total_fisik,
            tasod.sub_total_sistem_capture_stok,
            tasod.waktu_capture_stok_adj,
            tasod.qty_fisik_adj,
            tasod.qty_sistem_capture_stok_adj,
            tasod.sub_total_fisik_adj,
            tasod.sub_total_sistem_capture_stok_adj,
            tasod.qty_proses_selisih,
            tasod.sub_total_proses_selisih,
            tasod.created_by,
            tasod.updated_by,
            tasod.created_at,
            tasod.updated_at
            from tr_audit_stok_opname_detail tasod
            inner join ms_barang mb on tasod.id_barang = mb.id_barang
            where tasod.id_audit_stok_opname = ?
            order by no_urut
        ",[request()->id_audit_stok_opname]);            
    }

    public function count_detail(){
        $data = DB::select("
            select count(*) 
            from tr_audit_stok_opname_detail 
            where id_audit_stok_opname= ?
        ",[request()->id_audit_stok_opname]);
        return $data[0]->count;          
    }

    public function barang(){
        $barang = msBarang::where('id_barang',request()->id_barang)->first(); 
        $barang->harga_jual = $this->repository_setting_harga->harga_jual_by_id_barang(request()->id_barang);
        return $barang;
    }

    public function capture_from_kartu_stok($waktu_capture){
        $capure_kartustok = msBarangKartuStok::where('created_at','<=',$waktu_capture)
            ->orderBy('created_at','desc')->first();
        if(!$capure_kartustok){
            $capure_kartustok = (object)[
                'stok_akhir' => 0,
                'nominal_akhir' => 0,
            ];
        }
        return $capure_kartustok;
    }
}
