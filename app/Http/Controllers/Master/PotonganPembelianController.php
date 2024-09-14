<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\potonganPembelianRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class PotonganPembelianController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new potonganPembelianRepository();
        parent::__construct($this->repository);
    }
}
