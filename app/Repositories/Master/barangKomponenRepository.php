<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangKomponen;
use Viershaka\Vier\VierRepository;

class barangKomponenRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangKomponen());
    }
}
