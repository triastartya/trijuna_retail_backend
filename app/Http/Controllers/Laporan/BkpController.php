<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class BkpController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function bkp(){
        $data=DB::select("
            SELECT pp.tanggal_penjualan,mb.kode_barang,mb.barcode,mb.nama_barang,sum(ppd.qty_jual) as total_qty,sum(ppd.sub_total) as subtotal from pos_penjualan pp 
            inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            inner join ms_barang mb on ppd.id_barang=mb.id_barang
            where pp.tanggal_penjualan BETWEEN ? and ? and mb.is_ppn = true
            group by pp.tanggal_penjualan,mb.kode_barang,mb.barcode,mb.nama_barang;
        ",[request()->startdate,request()->enddate]);
        $total_jumlah_harian = 0;
        $total_dpp_harian = 0;
        $total_ppn_harian = 0;
        foreach($data as $index=>$item){
            $ppn = (float)$item->subtotal * 0.11;            
            $data[$index]->subtotal = (float)$item->subtotal;
            $data[$index]->ppn = $ppn;
            $data[$index]->dpp = (float)$item->subtotal - $ppn;

            $total_jumlah_harian = $total_jumlah_harian + (float)$item->subtotal;
            $total_dpp_harian = $total_dpp_harian + (float)$item->subtotal - $ppn;
            $total_ppn_harian = $total_ppn_harian + $ppn;
        }
        return response()->json(['success'=>true,'data'=>[
            "total_jumlah_harian" =>$total_jumlah_harian,
            "total_dpp_harian" =>$total_dpp_harian,
            "total_ppn_harian" =>$total_ppn_harian,
            "detail"=>$data
        ]]);
    }

    public function non_bkp(){
        $data=DB::select("
            SELECT pp.tanggal_penjualan,mb.kode_barang,mb.barcode,mb.nama_barang,sum(ppd.qty_jual) as total_qty,sum(ppd.sub_total) as subtotal from pos_penjualan pp 
            inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            inner join ms_barang mb on ppd.id_barang=mb.id_barang
            where pp.tanggal_penjualan BETWEEN ? and ? and mb.is_ppn = false
            group by pp.tanggal_penjualan,mb.kode_barang,mb.barcode,mb.nama_barang;
        ",[request()->startdate,request()->enddate]);
        $total_jumlah_harian = 0;
        $total_dpp_harian = 0;
        $total_ppn_harian = 0;
        foreach($data as $index=>$item){
            $ppn = (float)$item->subtotal * 0.11;
            $data[$index]->subtotal = (float)$item->subtotal;
            $data[$index]->ppn = $ppn;
            $data[$index]->dpp = (float)$item->subtotal - $ppn;

            $total_jumlah_harian = $total_jumlah_harian + (float)$item->subtotal;
            $total_dpp_harian = $total_dpp_harian + (float)$item->subtotal - $ppn;
            $total_ppn_harian = $total_ppn_harian + $ppn;
        }
        return response()->json(['success'=>true,'data'=>[
            "total_jumlah_harian" =>$total_jumlah_harian,
            "total_dpp_harian" =>$total_dpp_harian,
            "total_ppn_harian" =>$total_ppn_harian,
            "detail"=>$data
        ]]);
    }

    public function rekap_bkp(){
        $data=DB::select("
            SELECT pp.tanggal_penjualan,sum(ppd.qty_jual) as total_qty,sum(ppd.sub_total) as subtotal from pos_penjualan pp 
            inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            inner join ms_barang mb on ppd.id_barang=mb.id_barang
            where pp.tanggal_penjualan BETWEEN ? and ? and mb.is_ppn = true
            group by pp.tanggal_penjualan;
        ",[request()->startdate,request()->enddate]);
        $total_jumlah_harian = 0;
        $total_dpp_harian = 0;
        $total_ppn_harian = 0;
        foreach($data as $index=>$item){
            $ppn = (float)$item->subtotal * 0.11;
            $data[$index]->subtotal = (float)$item->subtotal;
            $data[$index]->ppn = $ppn;
            $data[$index]->dpp = (float)$item->subtotal - $ppn;

            $total_jumlah_harian = $total_jumlah_harian + (float)$item->subtotal;
            $total_dpp_harian = $total_dpp_harian + (float)$item->subtotal - $ppn;
            $total_ppn_harian = $total_ppn_harian + $ppn;
        }
        return response()->json(['success'=>true,'data'=>[
            "total_jumlah_harian" =>$total_jumlah_harian,
            "total_dpp_harian" =>$total_dpp_harian,
            "total_ppn_harian" =>$total_ppn_harian,
            "detail"=>$data
        ]]);
    }
}
