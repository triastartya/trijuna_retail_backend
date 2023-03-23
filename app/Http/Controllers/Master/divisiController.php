<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\divisiRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class divisiController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new divisiRepository();

        parent::__construct($this->repository);
    }
}
