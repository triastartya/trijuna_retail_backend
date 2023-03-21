<?php

namespace App\Repositories\Master;

use App\Models\Master\msSupplier;
use Viershaka\Vier\VierRepository;

class supplierRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msSupplier());
    }
}
