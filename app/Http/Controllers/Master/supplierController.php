<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\supplierRepository;
use App\Services\Master\supplierService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class supplierController extends AttController
{
    public function __construct()
    {
        $repository = new supplierRepository();
        $service = new supplierService();

        parent::__construct($repository, $service);
    }
}
