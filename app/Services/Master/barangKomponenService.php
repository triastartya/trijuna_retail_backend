<?php

namespace App\Services\Master;

use App\Models\Master\msBarangKomponen;
use Att\Workit\AttService;

class barangKomponenService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msBarangKomponen());
    }
}
