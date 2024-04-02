<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Repositories\Penjualan\msPromoBonusSettingItemRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class msPromoBonusSettingItemController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new msPromoBonusSettingItemRepository();
        parent::__construct($this->repository);
    }
}
