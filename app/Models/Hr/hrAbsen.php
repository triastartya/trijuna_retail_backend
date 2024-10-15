<?php

namespace App\Models\Hr;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hrAbsen extends Model
{
    use HasFactory,VierModel;
    protected $table = 'hr_absen';
    public $timestamps = false;
    protected $fillable = [
        'id_absen',
        'id_karyawan',
        'masuk1',
        'keluar1',
        'masuk2',
        'keluar2',
        'tanggal'
    ];
    protected $primaryKey = 'id_absen';
    protected $modelFields = [
        ['name' => 'id_karyawan', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'masuk1', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'keluar1', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'masuk2', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'keluar2', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'tanggal', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_absen' =>'',
            'id_karyawan' =>'',
            'masuk1' =>'',
            'keluar1' =>'',
            'masuk2' =>'',
            'keluar2' =>'',
            'tanggal' =>''
        ];
    }
}
