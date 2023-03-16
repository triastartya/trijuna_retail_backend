<?php

namespace App\Repositories\Master;

use App\Models\Master\msMerk;
use Att\Workit\AttRepository;

class merkRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msMerk());
    }
}
