<?php

namespace App\Services\Master;

use App\Models\Master\msSatuan;
use Att\Workit\AttService;

class satuanService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msSatuan());
    }
}
