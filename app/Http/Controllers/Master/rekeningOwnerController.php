<?php

namespace App\Http\Controllers\Master;

use App\Repositories\Master\rekeningOwnerRepository;
use Viershaka\Vier\VierController;

class rekeningOwnerController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new rekeningOwnerRepository();
        parent::__construct($this->repository);
    }
}
