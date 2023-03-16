<?php

namespace App\Services\Master;

use App\Models\Master\msBarangUrai;
use Att\Workit\AttService;

class barangUraiService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msBarangUrai());
    }
}
