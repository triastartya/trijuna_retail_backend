<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoHadiahRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoHadianController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoHadiahRepository();
        parent::__construct($this->repository);
    }
}
