<?php

namespace App\Repositories\Master;

use App\Models\Master\msWarehouse;
use Viershaka\Vier\VierRepository;

class warehouseRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msWarehouse());
    }
}
