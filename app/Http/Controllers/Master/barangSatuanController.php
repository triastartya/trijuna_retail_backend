<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangSatuanRepository;
use App\Services\Master\barangSatuanService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class barangSatuanController extends AttController
{
    public function __construct()
    {
        $repository = new barangSatuanRepository();
        $service = new barangSatuanService();

        parent::__construct($repository, $service);
    }
}
