<?php

namespace App\Repositories\Master;

use App\Models\Master\msGroup;
use Viershaka\Vier\VierRepository;

class groupRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msGroup());
    }
}
