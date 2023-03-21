<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\memberRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;

class memberController extends VierController
{
    public function __construct()
    {
        $repository = new memberRepository();

        parent::__construct($repository);
    }
}
