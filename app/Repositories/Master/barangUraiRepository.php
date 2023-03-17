<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangUrai;
use Att\Workit\AttRepository;

class barangUraiRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangUrai());
    }
}
