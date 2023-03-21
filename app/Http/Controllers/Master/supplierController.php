<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\supplierRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class supplierController extends VierController
{
    public function __construct()
    {
        $repository = new supplierRepository();

        parent::__construct($repository);
    }
}
