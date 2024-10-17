<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Hr\hrDepartemen;
use App\Repositories\Hr\departemenRepository;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class departemenController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new departemenRepository();
        parent::__construct($this->repository);
    }

    public function getall()
    {
        $data = hrDepartemen::all();
        return response()->json(['success'=>true,'data'=>$data]);
    }
}
