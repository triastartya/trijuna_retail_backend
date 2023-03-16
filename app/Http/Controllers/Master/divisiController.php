<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\divisiRepository;
use App\Services\Master\divisiService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class divisiController extends AttController
{
    public function __construct()
    {
        $repository = new divisiRepository();
        $service = new divisiService();

        parent::__construct($repository, $service);
    }
}
