<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\warehouseRepository;
use App\Services\Master\warehouseService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class warehouseController extends AttController
{
    public function __construct()
    {
        $repository = new warehouseRepository();
        $service = new warehouseService();

        parent::__construct($repository, $service);
    }
}
