<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoHadiah;
use Viershaka\Vier\VierRepository;

class msPromoHadiahRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoHadiah());
    }
}
