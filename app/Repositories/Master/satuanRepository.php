<?php

namespace App\Repositories\Master;

use App\Models\Master\msSatuan;
use Viershaka\Vier\VierRepository;

class satuanRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msSatuan());
    }
}
