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

        }

    }

    public function SearchByID($data){

        $result = $this->PropertySqlHandler->SearchByID($data);
        return $result;


    }

    public function SearchByCity($data){

        try{
            $result = $this->PropertySqlHandler->SearchByCity($data);


            return $result;
        } catch(\Exception $e){
            DB::rollback();

        }

    }
    public function SearchWithPrice($data){

        try{
            $result = $this->PropertySqlHandler->SearchWithPrice($data);


            return $result;
        } catch(\Exception $e){
            DB::rollback();

        }

    }

    public function SearchWithUser($data){
        try{
            $result = $this->PropertySqlHandler->SearchWithUser($data);
            return $result;
        } catch(\Exception $e){
            DB::rollback();
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

    public function SearchWithMaxPrice($data){

        try
        {
            $result = $this->PropertySqlHandler->SearchWithMaxPrice($data);

            return $result;
        }
        catch(\Exception $e)
        {
            DB::rollback();

        }

    }

    public function SearchWithMinPrice($data){

        try
        {
            $result = $this->PropertySqlHandler->SearchWithMinPrice($data);

            return $result;
        }
        catch(\Exception $e)
        {
            DB::rollback();

        }

    }

}