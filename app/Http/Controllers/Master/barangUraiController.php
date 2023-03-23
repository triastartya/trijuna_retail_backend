<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangUraiRepository;
use App\Services\Master\barangUraiService;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class barangUraiController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new barangUraiRepository();

        parent::__construct($this->repository);
    }
}
