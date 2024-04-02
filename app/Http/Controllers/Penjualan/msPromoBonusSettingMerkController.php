<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoBonusSettingMerkRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoBonusSettingMerkController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoBonusSettingMerkRepository();
        parent::__construct($this->repository);
    }
}
