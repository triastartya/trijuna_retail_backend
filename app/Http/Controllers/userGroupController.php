<?php

namespace App\Http\Controllers;

use App\Repositories\Master\userGroupRepository;
use App\Services\Master\userGroupService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class userGroupController extends AttController
{
    public function __construct()
    {
        $repository = new userGroupRepository();
        $service = new userGroupService();

        parent::__construct($repository, $service);
    }
}
