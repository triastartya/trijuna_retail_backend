<?php

namespace App\Repositories\Penjualan;

use App\Helpers\QueryHelper;
use App\Models\Penjualan\posRefund;
use Illuminate\Support\Facades\DB;
use Viershaka\Vier\VierRepository;

class refundRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posRefund());
    }

    public function get_by_id(){
        $data = DB::select("
            select pr.id_refund,
            pr.id_user_kasir,
            pr.id_penjualan,
            pr.tanggal_refund,
            pr.keterangan,
            pr.total_refund,
            pr.is_deleted,
            pr.deleted_by,
            pr.deleted_at,
            pr.deleted_reason,
            pr.created_by,
            pr.updated_by,
            pr.id_tutup_kasir,
            pr.created_at,
            pr.updated_at,
            pr.no_retur_penjualan,
            u.nama as nama_kasir
            from pos_refund pr
            inner join users u on pr.id_user_kasir = u.id_user
            where pr.id_refund = ? 
        ",[request()->id_refund]);    
        return $data[0];        
    }

    public function get_detail(){
        return DB::select("
            select prd.id_refund_detail,
            prd.id_refund,
            prd.urut,
            prd.id_barang,
            mb.kode_barang,
            mb.barcode,
            mb.nama_barang,
            prd.qty_jual,
            prd.kode_satuan,
            prd.harga_jual,
            prd.created_at,
            prd.updated_at,
            prd.sub_total
            from pos_refund_detail prd
            inner join ms_barang mb on prd.id_barang = mb.id_barang
            where id_refund = ?
            order by urut
        ",[request()->id_refund]);            
    }

    public function by_param(){
        return QueryHelper::queryParam("
            select pr.id_refund,
            pr.id_user_kasir,
            pr.id_penjualan,
            pr.tanggal_refund,
            pr.keterangan,
            pr.total_refund,
            pr.is_deleted,
            pr.deleted_by,
            pr.deleted_at,
            pr.deleted_reason,
            pr.created_by,
            pr.updated_by,
            pr.id_tutup_kasir,
            pr.created_at,
            pr.updated_at,
            pr.no_retur_penjualan,
            u.nama as nama_kasir
            from pos_refund pr
            inner join users u on pr.id_user_kasir = u.id_user
            where is_deleted = false 
        ",request());
    }
}
