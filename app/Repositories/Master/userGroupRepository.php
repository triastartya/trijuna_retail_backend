<?php

namespace App\Repositories\Master;

use Att\Workit\AttRepository;
use App\Models\Master\userGroup;

class userGroupRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new userGroup());
    }
}