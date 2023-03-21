<?php

namespace App\Repositories\Master;

use App\Models\Master\msLokasi;
use Viershaka\Vier\VierRepository;

class LokasiRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msLokasi());
    }
}
