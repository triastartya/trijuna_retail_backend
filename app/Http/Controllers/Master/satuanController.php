<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\satuanRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class satuanController extends VierController
{
    public function __construct()
    {
        $repository = new satuanRepository();

        parent::__construct($repository);
    }
}
