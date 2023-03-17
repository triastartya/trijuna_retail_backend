<?php

namespace App\Services\Master;

use App\Models\Master\msBarangSatuan;
use Att\Workit\AttService;

class barangSatuanService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msBarangSatuan());
    }
}
