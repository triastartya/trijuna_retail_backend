<?php

namespace App\Http\Controllers;

use App\Repositories\Master\userGroupRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class userGroupController extends VierController
{
    public function __construct()
    {
        $repository = new userGroupRepository();

        parent::__construct($repository);
    }
}
