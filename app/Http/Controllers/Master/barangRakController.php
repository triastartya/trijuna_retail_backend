<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangRakRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangRakController extends VierController
{
    public function __construct()
    {
        $repository = new barangRakRepository();

        parent::__construct($repository);
    }
}
