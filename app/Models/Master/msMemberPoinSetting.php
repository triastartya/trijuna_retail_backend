<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class msMemberPoinSetting extends Model
{
    use HasFactory;
    protected $table = 'ms_member_poin_setting';
    protected $fillable = [
        'nominal',
        'dapat_poin',
        'group'
    ];
    protected $primaryKey = 'id_member_poin_setting';
}
