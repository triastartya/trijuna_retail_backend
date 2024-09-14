<?php

namespace App\Repositories\Master;

use App\Models\Master\msRekeningOwner;
use Viershaka\Vier\VierRepository;

class rekeningOwnerRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msRekeningOwner());
    }
}
