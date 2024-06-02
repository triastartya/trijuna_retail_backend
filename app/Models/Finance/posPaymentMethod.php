<?php

namespace App\Models\Finance;

use App\Traits\CreatedUpdatedBy;
use Viershaka\Vier\VierModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posPaymentMethod extends Model
{
    use HasFactory, VierModel, CreatedUpdatedBy;

    protected $table = 'pos_payment_method';
    
    protected $primaryKey = 'id_payment_method';
    
    protected $fillable = [
        'id_payment_method',
        'nama_payment_method',
        'keterangan'
    ];
    
    public function rules()
    {
        return [
            'id_payment_method'=>'',
            'nama_payment_method'=>'required',
            'keterangan'=>''
        ];
    }
}
