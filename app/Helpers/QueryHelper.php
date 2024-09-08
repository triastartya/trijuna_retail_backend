<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class QueryHelper
{
    public static function queryParam($query,$parameter,String $lastString='')
    {
        $i = 0;
        
        foreach($parameter->filter as $filter){
            $opration = '';
            $value = '';
            
            if($filter['filter']=='equel'){
                $column = "UPPER(".$filter['column'].")";
                $opration = '=';
                $value = "'".strtoupper($filter['value'])."'";
            }
            
            if($filter['filter']=='contain'){
                $column = "UPPER(".$filter['column'].")";
                $opration = 'like';
                $value = "'%".strtoupper($filter['value'])."%'";
            }
            
            if($filter['filter']=='between'){
                $column = $filter['column'];
                $opration = 'between';
                $value = "'".$filter['value']."'"." and "."'".$filter['value2']."'";
            }
            
            if($i==0){
                $iswhere = (str_contains($query,'where'))?" and ":" where ";
                $query .= $iswhere.$column." ".$opration." ".$value;
            }else{
                $query .= " and ".$column." ".$opration." ".$value;
            }
            $i++;
        }
        
        if($lastString==''){
            $query .= ' limit 300';
        }else{
            $query .= $lastString;
        }
        
        return DB::select($query);
    }
}