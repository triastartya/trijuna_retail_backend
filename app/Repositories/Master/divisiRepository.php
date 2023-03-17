<?php

namespace App\Repositories\Master;

use App\Models\Master\msDivisi;
use Att\Workit\AttRepository;

class divisiRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msDivisi());
    }
}
