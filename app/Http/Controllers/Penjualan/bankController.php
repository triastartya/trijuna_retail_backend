<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\bankRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class bankController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new bankRepository();
        parent::__construct($this->repository);
    }
}
