<?php

namespace App\Repositories\Finance;

use Viershaka\Vier\VierRepository;
use App\Models\Finance\posModalKasir;

class kasirRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posModalKasir());
    }
}