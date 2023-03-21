<?php

namespace App\Repositories\Master;

use App\Models\Master\msRak;
use Viershaka\Vier\VierRepository;

class rakRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msRak());
    }
}
