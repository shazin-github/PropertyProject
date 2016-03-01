<?php
namespace App\PropertyMySQL\Property;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\Property\PropertySqlHandler;

class Property{

    protected $PropertySqlHandler;

    public function __construct(PropertySqlHandler $PropertySqlHandler)
    {

        $this->PropertySqlHandler = $PropertySqlHandler;

    }


    public function addproperty($data){

        //dd($data);

        DB::beginTransaction();
        try{
            $id = $this->PropertySqlHandler->addproperty($data);

            DB::commit();
            return $id;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }


    }

    public function updatebyID($data){



        DB::beginTransaction();
        try{
            $id = $this->PropertySqlHandler->updatebyID($data);

            DB::commit();
            return $id;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }

    }

    public function SearchByID($data){

        $result = $this->PropertySqlHandler->SearchByID($data);
        return $result;


    }

    public function SearchByStreet($data){

        try{
            $result = $this->PropertySqlHandler->SearchByStreet($data);


            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }

    }
    public function SearchWithPrice($data){

        try{
            $result = $this->PropertySqlHandler->SearchWithPrice($data);


            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }

    }

    public function showproperty(){


            $result = $this->PropertySqlHandler->showproperty();

            return $result;


    }

    public function livesearch($data){

        $result = $this->PropertySqlHandler->livesearch($data);

        return $result;
    }

}