<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\LokasiRepository;
use App\Services\Master\LokasiService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class lokasiController extends AttController
{
    public function __construct()
    {
        $repository = new LokasiRepository();
        $service = new LokasiService();

        parent::__construct($repository, $service);
    }
}
