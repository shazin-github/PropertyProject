<?php
namespace App\PropertyMySQL\PropertyCategory;
use \DB;
use GuzzleHttp\Client as Guzzle;


class PropertyCategorySqlHandler
{
	public function getCategoryList(){
        $result = DB::table('property_category')->get();

        if($result)
            return $result;
        else
            return false;
    }

    public function getCategoryById($data){

    	$result[] = DB::table('property_category')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;
    }
}