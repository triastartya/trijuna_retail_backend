<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoBonusSettingBarangRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoBonusSettingBarangController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoBonusSettingBarangRepository();
        parent::__construct($this->repository);
    }
}
