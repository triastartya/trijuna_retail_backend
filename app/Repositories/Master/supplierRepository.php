<?php

namespace App\Repositories\Master;

use App\Helpers\QueryHelper;
use App\Models\Master\msSupplier;
use Viershaka\Vier\VierRepository;

class supplierRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msSupplier());
    }
    
    public function by_param()
    {
        return QueryHelper::queryParam('
        select
            ms.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            ms.alamat,
            ms.kota,
            ms.kecamatan,
            ms.kelurahan,
            ms.keterangan,
            ms.is_pkp,
            ms.is_tanpa_po,
            ms.limit_hutang,
            ms.no_handphone,
            ms.email,
            ms.sisa_hutang,
            ms.is_active,
            uc.nama as created_by,
            uu.nama as updated_by,
            ms.created_at,
            ms.updated_at
        from ms_supplier ms
        inner join users uc on uc.id_user = ms.created_by
        inner join users uu on uu.id_user = ms.updated_by
        ',request(),' order by ms.kode_supplier DESC limit 300');
    }
    
    public function by_param_active()
    {
        return QueryHelper::queryParam('
        select
            ms.id_supplier,
            ms.kode_supplier,
            ms.nama_supplier,
            ms.alamat,
            ms.kota,
            ms.kecamatan,
            ms.kelurahan,
            ms.keterangan,
            ms.is_pkp,
            ms.is_tanpa_po,
            ms.limit_hutang,
            ms.no_handphone,
            ms.email,
            ms.sisa_hutang,
            ms.is_active,
            uc.nama as created_by,
            uu.nama as updated_by,
            ms.created_at,
            ms.updated_at
        from ms_supplier ms
        inner join users uc on uc.id_user = ms.created_by
        inner join users uu on uu.id_user = ms.updated_by
        where ms.is_active = true
        ',request(),' order by ms.kode_supplier DESC limit 300');
    }
}
