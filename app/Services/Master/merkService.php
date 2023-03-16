<?php

namespace App\Services\Master;

use App\Models\Master\msMerk;
use Att\Workit\AttService;

class merkService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msMerk());
    }
}
