<?php

namespace App\Http\Controllers;

use App\Models\Reports\TesModel;
use Illuminate\Http\Request;
use Viershaka\Vier\VierController;

class ReportController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function addtes(){
        $insert = new TesModel();
        $insert->title = 'title';
        $insert->nominal = 1000.00;
        $insert->tanggal = date('Y-m-d');
        $insert->save();
        return response('oke');
    }
    
    public function gettes(){
        $data = TesModel::all();
        return response($data);
    }
}
