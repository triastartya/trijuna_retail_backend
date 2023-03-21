<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangRak;
use Viershaka\Vier\VierRepository;

class barangRakRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangRak());
    }
}
