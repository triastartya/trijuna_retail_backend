<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangRakRepository;
use App\Services\Master\barangRakService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class barangRakController extends AttController
{
    public function __construct()
    {
        $repository = new barangRakRepository();
        $service = new barangRakService();

        parent::__construct($repository, $service);
    }
}
