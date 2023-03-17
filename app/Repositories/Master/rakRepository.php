<?php

namespace App\Repositories\Master;

use App\Models\Master\msRak;
use Att\Workit\AttRepository;

class rakRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msRak());
    }
}
