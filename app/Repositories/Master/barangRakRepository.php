<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangRak;
use Att\Workit\AttRepository;

class barangRakRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangRak());
    }
}
