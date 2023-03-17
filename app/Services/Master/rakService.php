<?php

namespace App\Services\Master;

use App\Models\Master\msRak;
use Att\Workit\AttService;

class rakService extends AttService
{
    public function __construct()
    {
        parent::__construct(new msRak());
    }
}
