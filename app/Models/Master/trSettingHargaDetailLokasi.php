<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trSettingHargaDetailLokasi extends Model
{
    use HasFactory;
    protected $table = 'tr_setting_harga_detail_lokasi';
    protected $primaryKey = 'id_setting_harga_detail_lokasi';
    protected $fillable = [
        'id_setting_harga_detail',
        'id_lokasi'
    ];
}
