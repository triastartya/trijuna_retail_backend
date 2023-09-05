<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\posBank;
use Viershaka\Vier\VierRepository;

class bankRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posBank());
    }
}
