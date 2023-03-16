<?php

namespace App\Repositories\Master;

use App\Models\Master\msSupplier;
use Att\Workit\AttRepository;

class supplierRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msSupplier());
    }
}
