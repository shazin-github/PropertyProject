<?php
namespace App\PropertyMySQL\Location;
use \DB;

use App\PropertyMySQL\Location\LocationSqlHandler;

use App\PropertyMySQL\Response\Response;

use GuzzleHttp\Client as Guzzle;

class Location{

    protected $Guzzle;
    protected $LocationSqlHandler;
    //protected $LocationMongoHandler;

    public function __construct(Guzzle $guzzle , LocationSqlHandler $locationSqlHandler  ){

        $this->Guzzle = $guzzle;

        //$this->LocationMongoHandler = $locationMongoHandler;

        $this->LocationSqlHandler =  $locationSqlHandler;

    }

    public function addLocation($data){


        DB::beginTransaction();
        try{
            $id = $this->LocationSqlHandler->addlocation($data);

            DB::commit();
            return $id;
        } catch(\Exception $e){
            DB::rollback();

        }


    }

    public function updateLocation($data){

        DB::beginTransaction();
        try{
            $result = $this->LocationSqlHandler->updateLocation($data);





            DB::commit();
            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }
    }

    public function ShowLocationbyId($data){

        try{
            $resultfromSQL  = $this->LocationSqlHandler->ShowLocationbyId($data);


            return $resultfromSQL;

        } catch (\Exception $e) {

        }

    }

    public function DisableById($id){

        DB::beginTransaction();

        try{

            $result = $this->LocationSqlHandler->DisabledById($id);
            DB::commit();
            return $result;

        }catch(\Exception $e) {

            DB::rollback();


        }
    }



}