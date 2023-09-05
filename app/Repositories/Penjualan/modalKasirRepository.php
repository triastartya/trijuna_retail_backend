<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\posModalKasir;
use Viershaka\Vier\VierRepository;

class modalKasirRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posModalKasir());
    }
}
