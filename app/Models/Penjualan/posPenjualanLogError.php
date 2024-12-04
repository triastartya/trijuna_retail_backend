<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posPenjualanLogError extends Model
{
    use HasFactory;
    protected $table = 'pos_penjualan_log_error';
    protected $fillable = ['no_faktur','date','request','error_message'];
}
