<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\rakRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class rakController extends VierController
{
    public function __construct()
    {
        $repository = new rakRepository();

        parent::__construct($repository);
    }
}
