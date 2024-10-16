<?php

namespace App\Repositories\Inventory;

use App\Helpers\QueryHelper;
use App\Models\Inventory\trInputStokOpname;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class trInputStokOpnameRepository extends VierRepository
{

    public function __construct(){
        parent::__construct(new trInputStokOpname());
    }

    public function setting_so_open_by_param(){
        return QueryHelper::queryParam("
            select id_setting_stok_opname,
            nomor_stok_opname,
            tanggal_setting_stok_opname,
            jenis_stok_opname,
            keterangan,
            status
            from tr_setting_stok_opname 
            where status = 'OPEN'
        ",request());
    }

    public function get_barang_by_setting_so(){
        return DB::select("
            select tssoc.id_setting_stok_opname_capture,
            tssoc.id_setting_stok_opname,
            tssoc.id_barang,
            mb.barcode,
            mb.kode_barang,
            mb.nama_barang
            from tr_setting_stok_opname_capture tssoc
            inner join ms_barang mb on tssoc.id_barang = mb.id_barang
            where tssoc.id_setting_stok_opname = ?
            order by mb.id_group,mb.id_divisi,mb.id_supplier;
        ",[request()->id_setting_stok_opname]);
    }

    public function get_by_id(){
        $data =  DB::select("
                select tiso.id_input_stok_opname,
                    tiso.id_setting_stok_opname,
                    tiso.keterangan,
                    tiso.id_user,
                    u.nama,
                    tiso.created_at,
                    tiso.updated_at
                from tr_input_stok_opname tiso
                inner join users u on tiso.id_user = u.id_user
                where tiso.id_input_stok_opname=?;
            ",[request()->id_setting_stok_opname]);
            
        return $data[0];
    }

    public function get_detail(){
        $data =  DB::select("
                select tisod.id_input_stok_opname_detail,
                    tisod.id_input_stok_opname,
                    tisod.id_barang,
                    tisod.qty_fisik,
                    tisod.keterangan,
                    mb.barcode,
                    mb.kode_barang,
                    mb.nama_barang,
                    mb.kode_satuan
                from tr_input_stok_opname_detail tisod
                inner join ms_barang mb on tisod.id_barang = mb.id_barang
                where tisod.id_input_stok_opname=?;
            ",[request()->id_setting_stok_opname]);
            
        return $data;
    }

    public function by_param(){
        return QueryHelper::queryParam("
            select tiso.id_input_stok_opname,
                tiso.id_setting_stok_opname,
                tiso.keterangan,
                tiso.id_user,
                u.nama,
                tiso.created_at,
                tiso.updated_at
            from tr_input_stok_opname tiso
            inner join users u on tiso.id_user = u.id_user;
        ",request());
    }
}