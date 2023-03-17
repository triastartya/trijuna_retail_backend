<?php

namespace App\Repositories\Master;

use App\Models\Master\msBarangKomponen;
use Att\Workit\AttRepository;

class barangKomponenRepository extends AttRepository
{
    public function __construct()
    {
        parent::__construct(new msBarangKomponen());
    }
}
