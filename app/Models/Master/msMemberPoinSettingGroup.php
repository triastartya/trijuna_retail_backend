<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class msMemberPoinSettingGroup extends Model
{
    use HasFactory;
    protected $table = 'ms_member_poin_setting_group';
    protected $fillable = [
        'id_member_poin_setting',
        'id_group'
    ];
    protected $primaryKey = 'id_member_poin_setting_group';
}
