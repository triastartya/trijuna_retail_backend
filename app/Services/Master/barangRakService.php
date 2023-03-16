<?php

namespace App\Services\Master;

use App\Models\Master\msBarangRak;
use Att\Workit\AttService;

class barangRakService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msBarangRak());
    }
}
