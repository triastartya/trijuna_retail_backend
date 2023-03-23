<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\merkRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class merkController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new merkRepository();

        parent::__construct($this->repository);
    }
}
