<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\groupRepository;
use App\Services\Master\groupService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class groupController extends AttController
{
    public function __construct()
    {
        $repository = new groupRepository();
        $service = new groupService();

        parent::__construct($repository, $service);
    }
}
