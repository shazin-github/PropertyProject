<?php
namespace App\PropertyMySQL\PropertyPurpose;
use \DB;
use GuzzleHttp\Client as Guzzle;


class PropertyPurposeSqlHandler
{
	public function getPurposeList(){
        $result = DB::table('property_purpose')->get();

        if($result)
            return $result;
        else
            return false;
    }

    public function getPurposeById($data){

    	$result[] = DB::table('property_purpose')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;
    }
}