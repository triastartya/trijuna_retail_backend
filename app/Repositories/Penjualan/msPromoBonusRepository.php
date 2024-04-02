<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\msPromoBonus;
use Viershaka\Vier\VierRepository;

class msPromoBonusRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPromoBonus());
    }
}
