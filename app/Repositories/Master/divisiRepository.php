<?php

namespace App\Repositories\Master;

use App\Models\Master\msDivisi;
use Viershaka\Vier\VierRepository;

class divisiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msDivisi());
    }
}
