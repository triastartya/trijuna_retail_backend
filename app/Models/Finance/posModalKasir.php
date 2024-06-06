<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Viershaka\Vier\VierModel;

class posModalKasir extends Model
{
    use HasFactory, VierModel, CreatedUpdatedBy;

    protected $table = 'pos_modal_kasir';
    
    protected $primaryKey = 'id_modal_kasir';
    
    protected $fillable = [
        'id_user_kasir',
        'tanggal_modal_kasir',
        'modal_kasir',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'deleted_reason',
        'created_by',
        'updated_by',
        'id_tutup_kasir'
    ];
    
    public function rules()
    {
        return [
            'id_user_kasir' => '',
            'tanggal_modal_kasir'=> 'required',
            'modal_kasir'=> 'required',
            'is_deleted'=> '',
            'deleted_by'=> '',
            'deleted_at'=> '',
            'deleted_reason'=> '',
            'created_by'=> 'required',
            'updated_by'=> '',
            'id_tutup_kasir'=> ''
        ];
    }
}
