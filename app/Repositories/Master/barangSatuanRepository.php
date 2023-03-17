<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangSatuan;
use Att\Workit\AttRepository;

class barangSatuanRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangSatuan());
    }
}
