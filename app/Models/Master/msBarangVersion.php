<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class msBarangVersion extends Model
{
    use HasFactory;
    protected $table = 'ms_barang_version';
    protected $primaryKey = 'id_barang_version';
    public $timestamps = false;
}