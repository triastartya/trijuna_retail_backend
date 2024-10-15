<?php

namespace App\Models\Hr;


use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hrKaryawan extends Model
{
    use HasFactory,VierModel;
    protected $table = 'hr_karyawan';
    public $timestamps = false;
    protected $fillable = [
        'id_karyawan',
        'kode_karyawan',
        'nama_karyawan',
        'alamat',
        'id_departemen'
    ];
    protected $primaryKey = 'id_karyawan';
    protected $modelFields = [
        ['name' => 'id_karyawan', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'kode_karyawan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_karyawan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'alamat', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'id_departemen', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_karyawan' =>'',
            'kode_karyawan' =>'',
            'nama_karyawan' =>'',
            'alamat' =>'',
            'id_departemen' => ''
        ];
    }
}
