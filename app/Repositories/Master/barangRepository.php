<?php

namespace App\Repositories\Master;

use App\Helpers\QueryHelper;
use App\Models\Master\msBarang;
use Viershaka\Vier\VierRepository;

class barangRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msBarang());
    }
    
    public function barang_by_param(){
        return QueryHelper::queryParam('
            
        ',request());

    }
}
