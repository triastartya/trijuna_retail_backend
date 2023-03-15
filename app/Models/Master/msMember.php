<?php

namespace App\Models\Master;

use Att\Workit\AttModel;
use Att\Workit\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class msMember extends Model
{
    use HasFactory,AttModel,CreatedUpdatedBy;
    
    protected $table = 'ms_member';
    protected $fillable = [
        'kode_member',
        'nama_member',
        'alamat',
        'kota',
        'kecamatan',
        'kelurahan',
        'pekerjaan',
        'jenis_kelamin',
        'no_handphone',
        'email',
        'password',
        'jenis_identitas',
        'nomor_identitas',
        'tanggal_daftar',
        'limit_piutang',
        'sisa_piutang',
        'jumlah_poin',
        'is_active',
    ];
    protected $primaryKey = 'id_member';
    protected $modelFields = [
        ['name' => 'id_member', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'kode_member', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_member', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'alamat', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'kota', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'kecamatan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'kelurahan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'pekerjaan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'jenis_kelamin', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'no_handphone', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'email', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'password', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'jenis_identitas', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nomor_identitas', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'tanggal_daftar', 'type' => ModelDictionary::COLUMN_TYPE_DATE],
        ['name' => 'limit_piutang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'sisa_piutang', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'jumlah_poin', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_member'     =>'',
            'kode_member'   =>'',
            'nama_member'   =>'required',
            'alamat'        =>'required',
            'kota'          =>'required',
            'kecamatan'     =>'required',
            'kelurahan'     =>'required',
            'pekerjaan'     =>'required',
            'jenis_kelamin' =>'required',
            'no_handphone'  =>'required',
            'email'         =>'required',
            'password'      =>'',
            'jenis_identitas'=>'required',
            'nomor_identitas'=>'required',
            'tanggal_daftar'=>'required',
            'limit_piutang' =>'required',
            'sisa_piutang'  =>'',
            'jumlah_poin'   =>'',
            'is_active'     =>'',
        ];
    }
}
