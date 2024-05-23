<?php

namespace App\Helpers;

use App\Models\Master\msLokasi;
use Illuminate\Support\Facades\DB;

class LokasiHelper
{
    public static function use()
    {
        $lokasi = msLokasi::where('is_use',true)->first();
        return $lokasi;
    }
}