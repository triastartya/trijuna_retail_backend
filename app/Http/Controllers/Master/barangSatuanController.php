<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangSatuanRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangSatuanController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new barangSatuanRepository();

        parent::__construct($this->repository);
    }
}
