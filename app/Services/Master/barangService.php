<?php

namespace App\Services\Master;

use App\Models\Master\msBarang;
use Att\Workit\AttService;

class barangService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msBarang());
    }
}
