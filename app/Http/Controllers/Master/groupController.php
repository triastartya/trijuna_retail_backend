<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\groupRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class groupController extends VierController
{
    public function __construct()
    {
        $repository = new groupRepository();

        parent::__construct($repository);
    }
}
