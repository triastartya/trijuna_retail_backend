<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\LokasiRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class lokasiController extends VierController
{
    public function __construct()
    {
        $repository = new LokasiRepository();

        parent::__construct($repository);
    }
}
