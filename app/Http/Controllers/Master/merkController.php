<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\merkRepository;
use App\Services\Master\merkService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class merkController extends AttController
{
    public function __construct()
    {
        $repository = new merkRepository();
        $service = new merkService();

        parent::__construct($repository, $service);
    }
}
