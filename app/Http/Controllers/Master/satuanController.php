<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\satuanRepository;
use App\Services\Master\satuanService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class satuanController extends AttController
{
    public function __construct()
    {
        $repository = new satuanRepository();
        $service = new satuanService();

        parent::__construct($repository, $service);
    }
}
