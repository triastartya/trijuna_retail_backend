<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoDiskonRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoDiskonController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoDiskonRepository();
        parent::__construct($this->repository);
    }
}
