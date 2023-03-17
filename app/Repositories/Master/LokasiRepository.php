<?php

namespace App\Repositories\Master;

use App\Models\Master\msLokasi;
use Att\Workit\AttRepository;

class LokasiRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msLokasi());
    }
}
