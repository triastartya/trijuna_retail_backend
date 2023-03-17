<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangRepository;
use App\Services\Master\barangService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class barangController extends AttController
{
    public function __construct()
    {
        $repository = new barangRepository();
        $service = new barangService();

        parent::__construct($repository, $service);
    }
}
