<?php

namespace App\Helpers;

use App\Models\nomorCounter;

class GeneradeNomorHelper
{
    public static function sort($keterangan)
    {
        $master_counter_forupdate = nomorCounter::where('keterangan',$keterangan)->lockForUpdate()->first();
        $master_counter_forupdate->counter = $master_counter_forupdate->counter + 1;
        $master_counter_forupdate->save();
        return sprintf('%04s', $master_counter_forupdate->counter);
    }
    
    public static function long($keterangan)
    {
        $pecah = explode('-', date('Y-m-d'));
        $master_counter_forupdate = nomorCounter::where('keterangan',$keterangan)->lockForUpdate()->first();
        if($master_counter_forupdate->tanggal != date('Y-m-d')){
            $master_counter_forupdate->counter = 1;
        }else{
            $master_counter_forupdate->counter = $master_counter_forupdate->counter + 1;
        }
        $master_counter_forupdate->tanggal = date('Y-m-d');
        $master_counter_forupdate->save();
        $nomor = $master_counter_forupdate->prefix . substr($pecah[0], -2) .$pecah[1] .$pecah[2] .sprintf('%04s', $master_counter_forupdate->counter);
        return $nomor;
    }
}