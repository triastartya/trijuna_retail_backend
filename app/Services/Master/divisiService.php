<?php

namespace App\Services\Master;

use App\Models\Master\msDivisi;
use Att\Workit\AttService;

class divisiService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msDivisi());
    }
}
