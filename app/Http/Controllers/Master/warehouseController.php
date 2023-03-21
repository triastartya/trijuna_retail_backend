<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\warehouseRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class warehouseController extends VierController
{
    public function __construct()
    {
        $repository = new warehouseRepository();

        parent::__construct($repository);
    }
}
