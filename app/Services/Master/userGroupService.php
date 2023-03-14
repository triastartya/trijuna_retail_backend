<?php

namespace App\Services\Master;

use Att\Workit\AttService;
use App\Models\Master\userGroup;

class userGroupService extends AttService
{
    public function __construct()
    {
        parent::__construct(new userGroup());
    }
}
