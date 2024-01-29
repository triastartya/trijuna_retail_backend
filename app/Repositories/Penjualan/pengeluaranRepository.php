<?php

namespace App\Repositories\Penjualan;

use App\Models\Penjualan\posPengeluaran;
use Viershaka\Vier\VierRepository;

class pengeluaranRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new posPengeluaran());
    }
}