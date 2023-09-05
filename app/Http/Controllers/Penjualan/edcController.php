<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\edcRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class edcController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new edcRepository();
        parent::__construct($this->repository);
    }
}
