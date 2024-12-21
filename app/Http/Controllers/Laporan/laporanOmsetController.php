<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class laporanOmsetController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function breakdown_monthly()
    {
        $data = DB::select("
            SELECT 
                EXTRACT(MONTH FROM pp.tanggal_penjualan) AS bulan, 
                SUM(ppd.sub_total) AS total_transaksi,
                SUM(ppd.hpp_average*ppd.qty_jual) AS hpp
            FROM 
                pos_penjualan pp 
			inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            WHERE 
                EXTRACT(YEAR FROM tanggal_penjualan) = ? 
            GROUP BY 
                EXTRACT(MONTH FROM tanggal_penjualan)
            ORDER BY 
                bulan;
        ",[request()->tahun]);
        $hasil = [];
        $komulatif = 0;
        foreach($data as $key=>$item){
            $komulatif = $komulatif + $item->total_transaksi;
            $hasil[]=[
                'urut'=>$key+1,
                'bulan'=>$item->bulan,
                'omset'=>$item->total_transaksi,
                'komilatif'=>$komulatif,
                'rata_rata'=>round(($komulatif)/($key+1),2)
            ];
        }

        $total_omset = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['omset'];
        }, 0);

        $total_komilatif = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['komilatif'];
        }, 0);

        $total_rata_rata = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['rata_rata'];
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $hasil,
            "total_omset" =>$total_omset,
            "total_komulatif" =>round($total_komilatif,2),
            "total_rata_rata" =>round($total_rata_rata,2),
        ]]);
    }

    public function breakdown_daily(){
        $data = DB::select("
            SELECT
            pp.tanggal_penjualan AS hari,
            SUM(ppd.sub_total) AS total_transaksi,
            SUM(ppd.hpp_average*ppd.qty_jual) AS hpp
            FROM
            pos_penjualan pp 
			inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            WHERE
            TO_CHAR(tanggal_penjualan, 'YYYY-MM') = ?
            GROUP BY
            tanggal_penjualan
            ORDER BY
            hari;
        ",[request()->bulan]);
        $hasil = [];
        $komulatif = 0;
        foreach($data as $key=>$item){
            $komulatif = $komulatif + $item->total_transaksi;
            $hasil[]=[
                'urut'=>$key+1,
                'hari'=>$item->hari,
                'omset'=>$item->total_transaksi,
                'komilatif'=>$komulatif,
                'rata_rata'=>round(($komulatif)/($key+1),2)
            ];
        }

        $total_omset = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['omset'];
        }, 0);

        $total_komilatif = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['komilatif'];
        }, 0);

        $total_rata_rata = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['rata_rata'];
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $hasil,
            "total_omset" =>$total_omset,
            "total_komulatif" =>round($total_komilatif,2),
            "total_rata_rata" =>round($total_rata_rata,2),
        ]]);
    }

    public function breakdown_profit_monthly()
    {
        $data = DB::select("
            SELECT 
                EXTRACT(MONTH FROM pp.tanggal_penjualan) AS bulan, 
                SUM(ppd.sub_total) AS total_transaksi,
                SUM(ppd.hpp_average*ppd.qty_jual) AS hpp
            FROM 
                pos_penjualan pp 
			inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            WHERE 
                EXTRACT(YEAR FROM tanggal_penjualan) = ? 
            GROUP BY 
                EXTRACT(MONTH FROM tanggal_penjualan)
            ORDER BY 
                bulan;
        ",[request()->tahun]);
        $hasil = [];
        $komulatif = 0;
        foreach($data as $key=>$item){
            $komulatif = $komulatif + $item->total_transaksi;
            $hasil[]=[
                'urut'=>$key+1,
                'bulan'=>$item->bulan,
                'omset'=>$item->total_transaksi,
                'komilatif'=>$komulatif,
                'rata_rata'=>round(($komulatif)/($key+1),2),
                'hpp'=>round($item->hpp,2),
                'profit'=>round($item->total_transaksi - $item->hpp,2)
            ];
        }

        $total_omset = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['omset'];
        }, 0);

        $total_komilatif = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['komilatif'];
        }, 0);

        $total_rata_rata = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['rata_rata'];
        }, 0);

        $total_hpp = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['hpp'];
        }, 0);

        $total_profit = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['profit'];
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $hasil,
            "total_omset" =>$total_omset,
            "total_komulatif" =>round($total_komilatif,2),
            "total_rata_rata" =>round($total_rata_rata,2),
            "total_hpp"=>round($total_hpp,2),
            "total_profit"=>round($total_profit,2),
        ]]);
    }

    public function breakdown_profit_daily(){
        $data = DB::select("
            SELECT
            pp.tanggal_penjualan AS hari,
            SUM(ppd.sub_total) AS total_transaksi,
            SUM(ppd.hpp_average*ppd.qty_jual) AS hpp
            FROM
            pos_penjualan pp 
			inner join pos_penjualan_detail ppd on pp.id_penjualan=ppd.id_penjualan
            WHERE
            TO_CHAR(tanggal_penjualan, 'YYYY-MM') = ?
            GROUP BY
            tanggal_penjualan
            ORDER BY
            hari;
        ",[request()->bulan]);
        $hasil = [];
        $komulatif = 0;
        foreach($data as $key=>$item){
            $komulatif = $komulatif + $item->total_transaksi;
            $hasil[]=[
                'urut'=>$key+1,
                'hari'=>$item->hari,
                'omset'=>$item->total_transaksi,
                'komilatif'=>$komulatif,
                'rata_rata'=>round(($komulatif)/($key+1),2),
                'hpp'=>round($item->hpp,2),
                'profit'=>round($item->total_transaksi - $item->hpp,2)
            ];
        }

        $total_omset = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['omset'];
        }, 0);

        $total_komilatif = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['komilatif'];
        }, 0);

        $total_rata_rata = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['rata_rata'];
        }, 0);

        $total_hpp = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['hpp'];
        }, 0);

        $total_profit = array_reduce($hasil, function($sum, $item) {
            return $sum + $item['profit'];
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $hasil,
            "total_omset" =>$total_omset,
            "total_komulatif" =>round($total_komilatif,2),
            "total_rata_rata" =>round($total_rata_rata,2),
            "total_hpp"=>round($total_hpp,2),
            "total_profit"=>round($total_profit,2),
        ]]);
    }
}
