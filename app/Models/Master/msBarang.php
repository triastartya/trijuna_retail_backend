<?php

namespace App\Models\Master;

use Viershaka\Vier\VierModel;
use Viershaka\Vier\Interfaces\ModelDictionary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
class msBarang extends Model
{
    use HasFactory,VierModel,CreatedUpdatedBy;
    
    protected $table = 'ms_barang';
    protected $fillable = [
        'id_divisi',
        'id_group',
        'kode_barang',
        'barcode',
        'image',
        'persediaan',
        'nama_barang',
        'id_merk',
        'ukuran',
        'warna',
        'berat',
        'id_supplier',
        'harga_order',
        'harga_beli_terakhir',
        'hpp_average',
        'is_ppn',
        'nama_label',
        'id_satuan',
        'margin',
        'tahun produksi',
        'stok_min',
        'is_active',
        'harga_jual'
    ];
    protected $primaryKey = 'id_barang';
    protected $modelFields = [
        ['name' => 'id_divisi', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_group', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'kode_barang', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'barcode', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'image', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'persediaan', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'nama_barang', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'id_merk', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'ukuran', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'warna', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'berat', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'berat', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'id_supplier', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'harga_order', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'harga_beli_terakhir', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'hpp_average', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'is_ppn', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name' => 'nama_label', 'type' => ModelDictionary::COLUMN_TYPE_STRING],
        ['name' => 'id_satuan', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'margin', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'tahun_produksi', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'stok_min', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER],
        ['name' => 'is_active', 'type' => ModelDictionary::COLUMN_TYPE_BOOLEAN],
        ['name' => 'harga_jual', 'type' => ModelDictionary::COLUMN_TYPE_INTEGER]
    ];
    protected $guarded = [];  
    protected $appends = [];
    public function rules()
    {
        return [
        'id_barang'=>'',
        'id_divisi'=>'',
        'id_group'=>'',
        'kode_barang'=>'required',
        'barcode'=>'required',
        'image'=>'',
        'persediaan'=>'',
        'nama_barang'=>'required',
        'id_merk'=>'',
        'ukuran'=>'',
        'warna'=>'required',
        'berat'=>'required',
        'id_supplier'=>'',
        'harga_order'=>'required',
        'harga_beli_terakhir'=>'required',
        'hpp_average'=>'required',
        'is_ppn'=>'required',
        'nama_label'=>'required',
        'id_satuan'=>'',
        'margin'=>'required',
        'tahun produksi'=>'',
        'stok_min'=>'required',
        'is_active'=>'',
        'created_by'=>'',
        'updated_by'=>'',
        'harga_jual'=>'required'
        ];
    }

    protected $casts = [
        'harga_order' => 'float',
        'harga_beli_terakhir' => 'float',
        'hpp_average' => 'float',
        'harga_jual' => 'float',
    ];

    public function stok(){
        return $this->hasMany(msBarangStok::class,'id_barang','id_barang');
    }
}
