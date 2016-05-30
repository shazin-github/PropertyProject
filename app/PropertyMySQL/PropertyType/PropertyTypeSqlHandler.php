<?php
namespace App\PropertyMySQL\PropertyType;
use \DB;
use GuzzleHttp\Client as Guzzle;


class PropertyTypeSqlHandler
{
	public function getTypeList(){
        $result = DB::table('property_type')->get();

        if($result)
            return $result;
        else
            return false;
    }

    public function getTypeById($data){

    	$result[] = DB::table('property_type')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;
    }
}