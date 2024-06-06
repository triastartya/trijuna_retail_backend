<?php

namespace App\Repositories\Finance;

use Viershaka\Vier\VierRepository;
use App\Models\Finance\posPaymentMethod;

class posPaymentMethodRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posPaymentMethod());
    }
}
