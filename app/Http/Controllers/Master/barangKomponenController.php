<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangKomponenRepository;
use App\Services\Master\barangKomponenService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class barangKomponenController extends AttController
{
    public function __construct()
    {
        $repository = new barangKomponenRepository();
        $service = new barangKomponenService();

        parent::__construct($repository, $service);
    }
}
