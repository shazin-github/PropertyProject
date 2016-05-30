<?php
namespace App\PropertyMySQL\PropertyType;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\PropertyType\PropertyTypeSqlHandler;

class PropertyType{

	protected $PropertyTypeSqlHandler;

	public function __construct(PropertyTypeSqlHandler $PropertyTypeSqlHandler)
    {

        $this->PropertyTypeSqlHandler = $PropertyTypeSqlHandler;

    }

    public function getTypeList(){

    	try{
    		$result = $this->PropertyTypeSqlHandler->getTypeList();
    		return $result;
    	}catch (\Exception $e){

        }

    }

    public function getTypeById($data){

    	try{
            $result  = $this->PropertyTypeSqlHandler->getTypeById($data);
            return $result;

        }catch (\Exception $e){

        }
    }


}