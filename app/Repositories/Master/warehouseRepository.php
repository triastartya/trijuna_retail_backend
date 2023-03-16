<?php

namespace App\Repositories\Master;

use App\Models\Master\msWarehouse;
use Att\Workit\AttRepository;

class warehouseRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msWarehouse());
    }
}
