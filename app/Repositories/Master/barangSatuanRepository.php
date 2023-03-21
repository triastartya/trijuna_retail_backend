<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangSatuan;
use Viershaka\Vier\VierRepository;

class barangSatuanRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangSatuan());
    }
}
