<?php

namespace App\Services\Master;

use App\Models\Master\msWarehouse;
use Att\Workit\AttService;

class warehouseService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msWarehouse());
    }
}
