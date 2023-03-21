<?php

namespace App\Repositories\Master;

use Viershaka\Vier\VierRepository;
use App\Models\Master\userGroup;

class userGroupRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new userGroup());
    }
}