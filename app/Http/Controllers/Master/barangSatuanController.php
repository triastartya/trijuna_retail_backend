<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangSatuanRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangSatuanController extends VierController
{
    public function __construct()
    {
        $repository = new barangSatuanRepository();

        parent::__construct($repository);
    }
}
