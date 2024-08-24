<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\msSupplier;
use App\Repositories\Master\supplierRepository;
use Viershaka\Vier\VierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class supplierController extends VierController
{
    public $repository;
    public function __construct()
    {
        $this->repository = new supplierRepository();
        
        parent::__construct($this->repository);
    }
    
    public function supplier_by_param()
    {
        try{
            $data = $this->repository->by_param();
            return response()->json(['success'=>true,'data'=>$data]);
        } catch (\Exception $ex) {
            return response()->json(['success'=>false,'data'=>[],'message'=>$ex->getMessage()]);
        }
    }

    public function import(){
        // DB::beginTransaction();
        try {
            $response = File::json(base_path().'/public/data/baru/supplier.json');
            $delete =msSupplier::truncate(); 
            $data = [];
            foreach($response['data'] as $item){
                $data[] = [
                    'id_supplier'=>$item['idSupplier'],
                    'kode_supplier'=>$item['kodeSupplier'],
                    'nama_supplier'=>$item['namaSupplier'],
                    'alamat'=>$item['alamat'],
                    'kota'=>$item['kota'],
                    'is_pkp'=>$item['isPKP'],
                    'is_tanpa_po'=>$item['isTanpaPO'],
                    'bank_rekening'=>$item['bankRekeningSupplier'],
                    'nama_pemilik_rekening'=>$item['namaPemilikRekeningSupplier'],
                    'nomor_rekening'=>$item['nomorRekeningSupplier'],
                    'limit_hutang'=>$item['limitCredit'],
                    'no_handphone'=>$item['telpKantor'],
                    'email'=>$item['emailKantor'],
                    'sisa_hutang'=>0,
                    'created_by'=>1,
                    'updated_by'=>1
                ];
            }
            //dd($data);
            msSupplier::insert($data);
            // DB::commit();
            return response()->json(['success'=>true,'data'=>$data]);
        }
        catch(\Exception $err) {
            // DB::rollBack();
            return response()->json(['success'=>false,'message'=>$err->getMessage()]);
        }
    }
}
