<?php

namespace App\Repositories\Hr;

use App\Models\Hr\hrDepartemen;
use Viershaka\Vier\VierRepository;

class departemenRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new hrDepartemen());
    }
}
