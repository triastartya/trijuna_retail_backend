<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\memberRepository;
use App\Services\Master\memberService;
use Att\Workit\AttController;
use Illuminate\Http\Request;

class memberController extends AttController
{
    public function __construct()
    {
        $repository = new memberRepository();
        $service = new memberService();

        parent::__construct($repository, $service);
    }
}
