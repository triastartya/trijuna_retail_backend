<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\rakRepository;
use App\Services\Master\rakService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class rakController extends AttController
{
    public function __construct()
    {
        $repository = new rakRepository();
        $service = new rakService();

        parent::__construct($repository, $service);
    }
}
