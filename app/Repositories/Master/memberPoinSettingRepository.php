<?php

namespace App\Repositories\Master;

use App\Models\Master\msMemberPoinSetting;
use Viershaka\Vier\VierRepository;

class memberPoinSettingRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msMemberPoinSetting());
    }
}
