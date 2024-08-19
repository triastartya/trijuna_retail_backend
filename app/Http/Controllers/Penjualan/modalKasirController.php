<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\modalKasirRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class modalKasirController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new modalKasirRepository();
        parent::__construct($this->repository);
    }
}