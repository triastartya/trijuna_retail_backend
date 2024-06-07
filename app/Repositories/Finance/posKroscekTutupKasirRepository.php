<?php

namespace App\Repositories\Finance;

use Viershaka\Vier\VierRepository;
use App\Models\Finance\posKroscekTutupKasir;

class posKroscekTutupKasirRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posKroscekTutupKasir());
    }
}
