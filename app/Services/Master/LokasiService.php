<?php

namespace App\Services\Master;

use App\Models\Master\msLokasi;
use Att\Workit\AttService;

class LokasiService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msLokasi());
    }
}
