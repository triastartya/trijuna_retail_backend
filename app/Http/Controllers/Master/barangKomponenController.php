<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangKomponenRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangKomponenController extends VierController
{
    public function __construct()
    {
        $repository = new barangKomponenRepository();

        parent::__construct($repository);
    }
}
