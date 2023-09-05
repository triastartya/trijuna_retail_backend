<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\posEdc;
use Viershaka\Vier\VierRepository;

class edcRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posEdc());
    }
}
