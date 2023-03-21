<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class QueryHelper
{
    public static function queryParam($query,$parameter)
    {
        $i = 0;
        foreach($parameter->filter as $filter){
            $opration = '';
            $value = '';
            
            if($filter['filter']=='equel'){
                $opration = '=';
                $value = "'".$filter['value']."'";
            }
            
            if($filter['filter']=='contain'){
                $opration = 'like';
                $value = "'%".$filter['value']."%'";
            }
            
            if($filter['filter']=='between'){
                $opration = 'between';
                $value = "'".$filter['value']."'"." and "."'".$filter['value2']."'";
            }
            
            if($i==0){
                $query .= " where ".$filter['column']." ".$opration." ".$value;
            }else{
                $query .= " and ".$filter['column']." ".$opration." ".$value;
            }
            $i++;
        }        
        return DB::select($query);
    }
}