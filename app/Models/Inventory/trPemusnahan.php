<?php

namespace App\Models\Inventory;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trPemusnahan extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'tr_pemusnahan';
    protected $primaryKey = 'id_pemusnahan';
    protected $fillable = [
        'id_pemusnahan',
        'nomor_pemusnahan',
        'tanggal_pemusnahan',
        'id_warehouse',
        'keterangan',
        'total_hpp_avarage',
        'status_pemusnahan',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'deleted_reason',
        'created_by',
        'updated_by'
    ];
    public function rules(){
        return[
            'id_pemusnahan'=>'',
            'nomor_pemusnahan'=>'required',
            'tanggal_pemusnahan'=>'required',
            'id_warehouse'=>'required',
            'keterangan'=>'',
            'total_hpp_avarage'=>'required',
            'status_pemusnahan'=>'required',
            'is_deleted'=>'',
            'deleted_by'=>'',
            'deleted_at'=>'',
            'deleted_reason'=>'',
            'created_by'=>'',
            'updated_by'=>''
        ];
    }
}