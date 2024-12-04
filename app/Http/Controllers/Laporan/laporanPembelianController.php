<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierController;

class laporanPembelianController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function ppn()
    {
        $data = DB::select("
            select
            EXTRACT(YEAR FROM tp.tanggal_nota) AS tahun,
            EXTRACT(MONTH FROM tp.tanggal_nota) AS bulan,
            mg.kode_group,
            mg.group,
            sum(tpd.qty) as qty,
            ROUND(sum(sum(tpd.harga_order*tpd.qty))::numeric,2) as nilai
            from tr_penerimaan tp 
            inner join tr_penerimaan_detail tpd on tp.id_penerimaan=tpd.id_penerimaan
            inner join ms_barang mb on tpd.id_barang=mb.id_barang
            inner join ms_group mg on mb.id_group=mg.id_group
            where status_penerimaan = 'VALIDATED' and mb.is_ppn = true
            AND TO_CHAR(tp.tanggal_nota, 'YYYY-MM') BETWEEN ? AND ?
            GROUP BY 
            EXTRACT(YEAR FROM tp.tanggal_nota),
            EXTRACT(MONTH FROM tp.tanggal_nota),
            mg.kode_group,mg.group;
        ",[request()->start,request()->end]);

        $total_qty = array_reduce($data, function($sum, $item) {
            return $sum + $item->qty;
        }, 0);

        $total_nilai = array_reduce($data, function($sum, $item) {
            return $sum + $item->nilai;
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
            EXTRACT(YEAR FROM tp.tanggal_nota) AS tahun,
            EXTRACT(MONTH FROM tp.tanggal_nota) AS bulan,
            mg.kode_group,
            mg.group,
            sum(tpd.qty) as qty,
            ROUND(sum(sum(tpd.harga_order*tpd.qty))::numeric,2) as nilai
            from tr_penerimaan tp 
            inner join tr_penerimaan_detail tpd on tp.id_penerimaan=tpd.id_penerimaan
            inner join ms_barang mb on tpd.id_barang=mb.id_barang
            inner join ms_group mg on mb.id_group=mg.id_group
            where status_penerimaan = 'VALIDATED' and mg.group like'%ROKOK%'
            AND TO_CHAR(tp.tanggal_nota, 'YYYY-MM') BETWEEN ? AND ?
            GROUP BY 
            EXTRACT(YEAR FROM tp.tanggal_nota),
            EXTRACT(MONTH FROM tp.tanggal_nota),
            mg.kode_group,mg.group;
        ",[request()->start,request()->end]);

        $total_qty = array_reduce($data, function($sum, $item) {
            return $sum + $item->qty;
        }, 0);

        $total_nilai = array_reduce($data, function($sum, $item) {
            return $sum + $item->nilai;
        }, 0);

        return response()->json(['success'=>true,'data'=>[
            "detail"=> $data,
            "total_qty" =>$total_qty,
            "total_nilai" =>round($total_nilai,2)
        ]]);
    }
}
