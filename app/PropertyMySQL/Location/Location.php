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

        //dd($data);

        //dd($this->LocationSqlHandler);

        DB::beginTransaction();
        try{
            $id = $this->LocationSqlHandler->addlocation($data);
            if(!$id)
                throw new \Exception('Location not inserted in SQL');
            //$data['_id'] = $id;



//            $mongoId = $this->LocationMongoHandler->addlocation($data);
//            if(!$mongoId)
//                throw new \Exception('Location not inserted in Mongo');
            DB::commit();
            return $id;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }


    }

    public function updateLocation($data){

        DB::beginTransaction();
        try{
            $result = $this->LocationSqlHandler->updateLocation($data);


            var_dump($result);
            if(!$result)
                throw new \Exception('Location not updated in SQL');


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



            if(!$resultfromSQL)

                throw new \Exception('Location not found in SQL');

            return $resultfromSQL;

        } catch (\Exception $e) {
            var_dump($e);
        }

    }

    public function DisableById($id){

        DB::beginTransaction();

        try{

            $result = $this->LocationSqlHandler->DisabledById($id);

            if(!$result){

                throw new \Exception('Recort Not Updated in SQL');
            }

            return $result;

        }catch(\Exception $e) {

            DB::rollback();

            var_dump($e);
        }
    }



}