<?php

namespace App\Services\Master;

use App\Models\Master\msGroup;
use Att\Workit\AttService;

class groupService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msGroup());
    }
}
