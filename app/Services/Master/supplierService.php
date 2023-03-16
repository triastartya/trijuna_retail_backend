<?php

namespace App\Services\Master;

use App\Models\Master\msSupplier;
use Att\Workit\AttService;

class supplierService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msSupplier());
    }
}
