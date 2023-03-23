<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\satuanRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class satuanController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new satuanRepository();

        parent::__construct($this->repository);
    }
}
