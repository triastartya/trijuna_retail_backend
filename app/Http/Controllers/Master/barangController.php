<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangController extends VierController
{
    public function __construct()
    {
        $repository = new barangRepository();

        parent::__construct($repository);
    }
}
