<?php

namespace App\Repositories\Master;

use App\Helpers\QueryHelper;
use App\Models\Master\msMember;
use Viershaka\Vier\VierRepository;

class memberRepository extends VierRepository
{
    public function __construct()
    {
        parent::__construct(new msMember());
    }
    
    public function by_param()
    {
        return QueryHelper::queryParam('
            select mm.id_member,
                   mm.kode_member,
                   mm.nama_member,
                   mm.alamat,
                   mm.kota,
                   mm.kecamatan,
                   mm.kelurahan,
                   mm.pekerjaan,
                   mm.jenis_kelamin,
                   mm.no_handphone,
                   mm.email,
                   mm.jenis_identitas,
                   mm.nomor_identitas,
                   mm.tanggal_daftar,
                   mm.limit_piutang,
                   mm.sisa_piutang,
                   mm.jumlah_poin,
                   mm.is_active,
                   uc.nama as created_by,
                   uu.nama as updated_by,
                   mm.created_at,
                   mm.updated_at from ms_member mm
            inner join users uc on uc.id_user = mm.created_by
            inner join users uu on uu.id_user = mm.updated_by
        ',request(),' order by kode_member DESC limit 300 ');
    }
    
    public function by_param_active(){
        return QueryHelper::queryParam('
            select mm.id_member,
                   mm.kode_member,
                   mm.nama_member,
                   mm.alamat,
                   mm.kota,
                   mm.kecamatan,
                   mm.kelurahan,
                   mm.pekerjaan,
                   mm.jenis_kelamin,
                   mm.no_handphone,
                   mm.email,
                   mm.jenis_identitas,
                   mm.nomor_identitas,
                   mm.tanggal_daftar,
                   mm.limit_piutang,
                   mm.sisa_piutang,
                   mm.jumlah_poin,
                   mm.is_active,
                   uc.nama as created_by,
                   uu.nama as updated_by,
                   mm.created_at,
                   mm.updated_at from ms_member mm
            inner join users uc on uc.id_user = mm.created_by
            inner join users uu on uu.id_user = mm.updated_by
            where mm.is_active = true
        ',request(),' order by kode_member DESC limit 300 ');
    }
}
