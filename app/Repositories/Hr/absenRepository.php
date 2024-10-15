<?php

namespace App\Repositories\Hr;

use App\Models\Hr\hrAbsen;
use Viershaka\Vier\VierRepository;

class absenRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new hrAbsen());
    }
}
