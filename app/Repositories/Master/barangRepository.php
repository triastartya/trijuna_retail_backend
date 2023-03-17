<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarang;
use Att\Workit\AttRepository;

class barangRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msBarang());
    }
}
