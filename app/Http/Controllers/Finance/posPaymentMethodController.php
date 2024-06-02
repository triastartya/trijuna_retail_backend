<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Viershaka\Vier\VierController;
use App\Models\Finance\posPaymentMethod;
use App\Repositories\Finance\posPaymentMethodRepository;
use Illuminate\Http\Request;

class posPaymentMethodController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        $this->repository = new posPaymentMethodRepository();
        parent::__construct($this->repository);
    }
}
