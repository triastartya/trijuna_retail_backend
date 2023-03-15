<?php

namespace App\Services\Master;

use App\Models\Master\msMember;
use Att\Workit\AttService;

class memberService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msMember());
    }
}
