<?php

namespace App\Helpers;

use App\Models\Master\msBarang;
use App\Models\Master\msBarangKartuStok;
use App\Models\Master\msBarangStok;
use Exception;
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
                'keterangan' => $data->keterangan
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
                'keterangan' => $data->keterangan
            ]);
        }
        return [true,'berhasil'];      
    }
    
    public static function pengurangan($data){
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
        
            if($barang_stok->qty < $data->qty){
                $barang = msBarang::where('id_barang',$data->id_barang)->first();
                return [false,'stok barang '.$barang->nama_barang.' tidak mencukupi, sisa stok '.$barang_stok->qty];
            }
            
            $barang_stok->qty = $barang_stok->qty - $data->qty;
            $barang_stok->save();
        }
        // update kartu stok
        $kartu_stok = msBarangKartuStok::where('id_barang',$data->id_barang)
                            ->orderBy('tanggal','desc')
                            ->orderBy('id_kartu_stok','desc')
                            ->lockForUpdate()
                            ->first();
        if($kartu_stok == null){
            return [false, $data->id_barang." stok tidak tersedia"];
        }                    
        msBarangKartuStok::create([
            'tanggal' => Date('Y-m-d'),
            'id_barang' => $data->id_barang,
            'id_warehouse' => $data->id_warehouse,
            'nomor_reff' => $data->nomor_reff,
            'id_header_trans' =>$data->id_header_trans,
            'id_detail_trans' =>$data->id_detail_trans,
            'stok_awal' =>$kartu_stok->stok_akhir,
            'nominal_awal' => $kartu_stok->nominal_akhir,
            'stok_masuk' =>0,
            'nominal_masuk' =>0,
            'stok_keluar' =>$data->qty,
            'nominal_keluar' =>$data->nominal,
            'stok_akhir'=>$kartu_stok->stok_akhir - $data->qty,
            'nominal_akhir'=>$kartu_stok->nominal_akhir - $data->nominal,
            'keterangan' => $data->keterangan
        ]);
        
        return [true,'berhasil'];
    }
    
    public static function hitung_hpp_avarage($id_barang,$qty,$subtotal){
        $master_barang = msBarang::where('id_barang',$id_barang)->first();
        $stok_on_hand = msBarangStok::where('id_barang',$id_barang)->sum('qty');
        $stok_persediaan = ($stok_on_hand)?$stok_on_hand:0;
        $hpp_average = ($master_barang->hpp_average)?$master_barang->hpp_average:0;
        if($hpp_average==0 || $stok_persediaan==0){
            $hpp_average = $subtotal/$qty;
        }else{
            $modal = $stok_persediaan*$hpp_average;
            $total_nominal_persediaan = $modal + $subtotal;
            $hpp_average = $total_nominal_persediaan / ($stok_persediaan+$qty);
        }
        $master_barang->hpp_average = floor($hpp_average);
        $master_barang->save();
        return true;
    }
}