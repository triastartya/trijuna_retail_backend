<?php

namespace App\Repositories\Master;

use App\Models\Master\msPotonganPembelian;
use Viershaka\Vier\VierRepository;

class potonganPembelianRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msPotonganPembelian());
    }
}
