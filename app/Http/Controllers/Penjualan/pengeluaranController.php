<?php

namespace App\Http\Controllers\penjualan;

use App\Repositories\Penjualan\pengeluaranRepository;
use Viershaka\Vier\VierController;

class pengeluaranController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new pengeluaranRepository();
        parent::__construct($this->repository);
    }
}