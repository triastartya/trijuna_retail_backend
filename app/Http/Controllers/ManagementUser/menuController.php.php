<?php

namespace App\Http\Controllers\ManagementUser;

use App\Http\Controllers\Controller;
use App\Models\ManagementUser\menus;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class menuController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function getMenuTree(){
        $data = menus::all();
    }
}
