<?php

namespace App\Repositories\Master;

use App\Models\Master\msMember;
use Viershaka\Vier\VierRepository;

class memberRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msMember());
    }
}
