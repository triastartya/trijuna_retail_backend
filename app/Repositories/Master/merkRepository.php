<?php

namespace App\Repositories\Master;

use App\Models\Master\msMerk;
use Viershaka\Vier\VierRepository;

class merkRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msMerk());
    }
}
