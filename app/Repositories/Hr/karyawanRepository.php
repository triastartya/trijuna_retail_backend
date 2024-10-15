<?php

namespace App\Repositories\Hr;

use App\Models\Hr\hrKaryawan;
use Viershaka\Vier\VierRepository;

class karyawanRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new hrKaryawan());
    }
}
