<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoDiskon;
use Viershaka\Vier\VierRepository;

class msPromoDiskonRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoDiskon());
    }
}
