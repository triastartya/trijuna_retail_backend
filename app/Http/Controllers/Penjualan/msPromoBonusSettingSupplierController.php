<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoBonusSettingSupplierRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoBonusSettingSupplierController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoBonusSettingSupplierRepository();
        parent::__construct($this->repository);
    }
}
