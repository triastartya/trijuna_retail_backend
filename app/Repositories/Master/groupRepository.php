<?php

namespace App\Repositories\Master;

use App\Models\Master\msGroup;
use Att\Workit\AttRepository;

class groupRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msGroup());
    }
}
