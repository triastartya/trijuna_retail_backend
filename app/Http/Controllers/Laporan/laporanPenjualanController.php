<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class laporanPenjualanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function grosir()
    {
        $data = DB::select("
            select
            EXTRACT(YEAR FROM pp.tanggal_penjualan) AS tahun,
            EXTRACT(MONTH FROM pp.tanggal_penjualan) AS bulan,
            mg.kode_group,
            mg.group,
            ROUND(sum(ppd.qty_jual)::numeric,2) as omset_qty,
            ROUND(sum(ppd.harga_jual*ppd.qty_jual)::numeric,2) as omset_nilai
            from pos_penjualan pp
            inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            inner join ms_barang mb on ppd.id_barang=mb.id_barang
            inner join ms_group mg on mb.id_group=mg.id_group
            where mb.is_ppn = true and ppd.qty_jual >= 2
            AND TO_CHAR(pp.tanggal_penjualan, 'YYYY-MM') BETWEEN ? AND ?
            GROUP BY
            EXTRACT(YEAR FROM pp.tanggal_penjualan),
            EXTRACT(MONTH FROM pp.tanggal_penjualan),
		    mg.kode_group,mg.group;
        ",[request()->start,request()->end]);

        $total_qty = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_qty;
        }, 0);

        $total_nilai = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_nilai;
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $data,
            "total_qty" =>$total_qty,
            "total_nilai" =>round($total_nilai,2)
        ]]);
    }

    public function eceran()
    {
        $data = DB::select("
            select 
            EXTRACT(YEAR FROM pp.tanggal_penjualan) AS tahun,
            EXTRACT(MONTH FROM pp.tanggal_penjualan) AS bulan,
            mg.kode_group,
            mg.group,
            ROUND(sum(ppd.qty_jual)::numeric,2) as omset_qty,
            ROUND(sum(ppd.harga_jual*ppd.qty_jual)::numeric,2) as omset_nilai
            from pos_penjualan pp 
            inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            inner join ms_barang mb on ppd.id_barang=mb.id_barang
            inner join ms_group mg on mb.id_group=mg.id_group
            where mb.is_ppn = true and ppd.qty_jual = 1
            AND TO_CHAR(pp.tanggal_penjualan, 'YYYY-MM') BETWEEN ? AND ?
            GROUP BY 
            EXTRACT(YEAR FROM pp.tanggal_penjualan),
            EXTRACT(MONTH FROM pp.tanggal_penjualan),
		    mg.kode_group,mg.group;
        ",[request()->start,request()->end]);

        $total_qty = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_qty;
        }, 0);

        $total_nilai = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_nilai;
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $data,
            "total_qty" =>$total_qty,
            "total_nilai" =>round($total_nilai,2)
        ]]);
    }

    public function sembako()
    {
        $data = DB::select("
            select
            EXTRACT(YEAR FROM pp.tanggal_penjualan) AS tahun,
            EXTRACT(MONTH FROM pp.tanggal_penjualan) AS bulan,
            mg.kode_group,
            mg.group,
            ROUND(sum(ppd.qty_jual)::numeric,2) as omset_qty,
            ROUND(sum(ppd.harga_jual*ppd.qty_jual)::numeric,2) as omset_nilai
            from pos_penjualan pp
            inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            inner join ms_barang mb on ppd.id_barang=mb.id_barang
            inner join ms_group mg on mb.id_group=mg.id_group
            where mb.is_ppn = true and TRIM(mg.kode_group)='50'
            AND TO_CHAR(pp.tanggal_penjualan, 'YYYY-MM') BETWEEN ? AND ?
            GROUP BY
            EXTRACT(YEAR FROM pp.tanggal_penjualan),
            EXTRACT(MONTH FROM pp.tanggal_penjualan),
		    mg.kode_group,mg.group;
        ",[request()->start,request()->end]);

        $total_qty = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_qty;
        }, 0);

        $total_nilai = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_nilai;
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $data,
            "total_qty" =>$total_qty,
            "total_nilai" =>round($total_nilai,2)
        ]]);
    }

    public function rokok()
    {
        $data = DB::select("
            select 
            EXTRACT(YEAR FROM pp.tanggal_penjualan) AS tahun,
            EXTRACT(MONTH FROM pp.tanggal_penjualan) AS bulan,
            mg.kode_group,
            mg.group,
            ROUND(sum(ppd.qty_jual)::numeric,2) as omset_qty,
            ROUND(sum(ppd.harga_jual*ppd.qty_jual)::numeric,2) as omset_nilai
            from pos_penjualan pp 
            inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            inner join ms_barang mb on ppd.id_barang=mb.id_barang
            inner join ms_group mg on mb.id_group=mg.id_group
            where mb.is_ppn = true and TRIM(mg.kode_group)='01'
            AND TO_CHAR(pp.tanggal_penjualan, 'YYYY-MM') BETWEEN ? AND ?
            GROUP BY 
            EXTRACT(YEAR FROM pp.tanggal_penjualan),
            EXTRACT(MONTH FROM pp.tanggal_penjualan),
		    mg.kode_group,mg.group;
        ",[request()->start,request()->end]);

        $total_qty = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_qty;
        }, 0);

        $total_nilai = array_reduce($data, function($sum, $item) {
            return $sum + $item->omset_nilai;
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $data,
            "total_qty" =>$total_qty,
            "total_nilai" =>round($total_nilai,2)
        ]]);
    }
}
