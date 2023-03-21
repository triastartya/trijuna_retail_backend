<?php

namespace App\Models;

use Viershaka\Vier\VierModel;
use Laravel\Sanctum\HasApiTokens;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasApiTokens, VierModel, Notifiable;
    
    protected $primaryKey = 'id_user';
    protected $modelFields = [
        ['name' => 'id', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'nama', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'id_group', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_level', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'email', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'verifikasi_email_at', 'type' => ModelDictionary::COLUMN_TYPE_DATE],
        ['name' => 'password', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    
    protected $guarded = [];  
    
    protected $appends = [];
    
    public function rules()
    {
        return [
            'id'=>'',
            'nama'=>'required',
            'id_group'=>'required',
            'id_level'=>'required',
            'email' => 'required',
            'verifikasi_email_at'=>'',
            'password' => 'required',
            'is_active' => '',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'id_group',
        'id_level',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
