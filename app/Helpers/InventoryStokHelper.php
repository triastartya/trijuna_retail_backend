<?php

namespace App\Helpers;

use App\Models\Master\msBarangKartuStok;
use App\Models\Master\msBarangStok;
use Illuminate\Support\Facades\DB;

class InventoryStokHelper
{
    public static function penambahan($data){
        $barang_stok = msBarangStok::where('id_barang',$data->id_barang)
                        ->where('id_warehouse',$data->id_warehouse)
                        ->lockForUpdate()->first();
        // update master barang stok
        if(!$barang_stok){
            msBarangStok::create([
                'id_barang' => $data->id_barang,
                'id_warehouse' => $data->id_warehouse,
                'qty' => $data->qty
            ]);
        }else{
            $barang_stok->qty = $barang_stok->qty + $data->qty;
            $barang_stok->save();
        }
        // update kartu stok
        $kartu_stok = msBarangKartuStok::where('id_barang',$data->id_barang)
                            ->orderBy('tanggal','desc')
                            ->orderBy('id_kartu_stok','desc')
                            ->lockForUpdate()
                            ->first();
        if(!$kartu_stok){
            msBarangKartuStok::create([
                'tanggal' => Date('Y-m-d'),
                'id_barang' => $data->id_barang,
                'id_warehouse' => $data->id_warehouse,
                'nomor_reff' => $data->nomor_reff,
                'id_header_trans' =>$data->id_header_trans,
                'id_detail_trans' =>$data->id_detail_trans,
                'stok_awal' =>0,
                'nominal_awal' => 0,
                'stok_masuk' =>$data->qty,
                'nominal_masuk' =>$data->nominal,
                'stok_keluar' =>0,
                'nominal_keluar' =>0,
                'stok_akhir'=>$data->qty,
                'nominal_akhir'=>$data->nominal,
                'keterangan' => ''
            ]);
        }else{
            msBarangKartuStok::create([
                'tanggal' => Date('Y-m-d'),
                'id_barang' => $data->id_barang,
                'id_warehouse' => $data->id_warehouse,
                'nomor_reff' => $data->nomor_reff,
                'id_header_trans' =>$data->id_header_trans,
                'id_detail_trans' =>$data->id_detail_trans,
                'stok_awal' =>$kartu_stok->stok_akhir,
                'nominal_awal' => $kartu_stok->nominal_akhir,
                'stok_masuk' =>$data->qty,
                'nominal_masuk' =>$data->nominal,
                'stok_keluar' =>0,
                'nominal_keluar' =>0,
                'stok_akhir'=>$kartu_stok->stok_akhir + $data->qty,
                'nominal_akhir'=>$kartu_stok->nominal_akhir + $data->nominal,
                'keterangan' => ''
            ]);
        }
        return [true,'berhasil'];      
    }
    
    public static function pengurangan($data)
    {
        return [true,'berhasil'];
    }
}