<?php
namespace App\PropertyMySQL\PropertyPurpose;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\PropertyPurpose\PropertyPurposeSqlHandler;

class PropertyPurpose{

	protected $PropertyPurposeSqlHandler;

	public function __construct(PropertyPurposeSqlHandler $PropertyPurposeSqlHandler)
    {

        $this->PropertyPurposeSqlHandler = $PropertyPurposeSqlHandler;

    }

    public function getPurposeList(){

    	try{
    		$result = $this->PropertyPurposeSqlHandler->getPurposeList();
    		return $result;
    	}catch (\Exception $e){

        }

    }

    public function getPurposeById($data){

    	try{
            $result  = $this->PropertyPurposeSqlHandler->getPurposeById($data);
            return $result;

        }catch (\Exception $e){

        }
    }


}