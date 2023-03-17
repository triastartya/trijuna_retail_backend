<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\barangUraiRepository;
use App\Services\Master\barangUraiService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class barangUraiController extends AttController
{
    public function __construct()
    {
        $repository = new barangUraiRepository();
        $service = new barangUraiService();

        parent::__construct($repository, $service);
    }
}
