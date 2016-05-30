<?php
namespace App\PropertyMySQL\PropertyCategory;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\PropertyCategory\PropertyCategorySqlHandler;

class PropertyCategory{

	protected $PropertyCategorySqlHandler;

	public function __construct(PropertyCategorySqlHandler $PropertyCategorySqlHandler)
    {

        $this->PropertyCategorySqlHandler = $PropertyCategorySqlHandler;

    }

    public function getCategoryList(){

    	try{
    		$result = $this->PropertyCategorySqlHandler->getCategoryList();
    		return $result;
    	}catch (\Exception $e){

        }

    }

    public function getCategoryById($data){

    	try{
            $result  = $this->PropertyCategorySqlHandler->getCategoryById($data);
            return $result;

        }catch (\Exception $e){

        }
    }


}