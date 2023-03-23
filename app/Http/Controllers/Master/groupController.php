<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\groupRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class groupController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new groupRepository();

        parent::__construct($this->repository);
    }
}
