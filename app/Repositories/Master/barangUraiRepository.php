<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangUrai;
use Viershaka\Vier\VierRepository;

class barangUraiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangUrai());
    }
}
