<?php

namespace App\Repositories\Master;

use App\Models\Master\msSatuan;
use Att\Workit\AttRepository;

class satuanRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msSatuan());
    }
}
