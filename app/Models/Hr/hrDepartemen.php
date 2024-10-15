<?php

namespace App\Models\Hr;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hrDepartemen extends Model
{
    use HasFactory,VierModel;
    protected $table = 'hr_departemen';
    public $timestamps = false;
    protected $fillable = [
        'id_departemen',
        'kode_departemen',
        'nama_departemen'
    ];
    protected $primaryKey = 'id_departemen';
    protected $modelFields = [
        ['name' => 'id_departemen', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'kode_departemen', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_departemen', 'type' => ModelDictionary::COLUMN_TYPE_STRING]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
            'id_departemen' =>'',
            'kode_departemen' =>'',
            'nama_departemen' =>'',
            'keluar1' =>''
        ];
    }
}
