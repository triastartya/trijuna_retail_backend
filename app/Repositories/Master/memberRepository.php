<?php

namespace App\Repositories\Master;

use App\Models\Master\msMember;
use Att\Workit\AttRepository;

class memberRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msMember());
    }
}
