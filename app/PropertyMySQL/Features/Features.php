<?php
namespace App\PropertyMySQL\Features;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\Features\FeaturesSqlHandler;

use App\PropertyMySQL\Response\Response;

class Features{

    protected $Guzzle;
    protected $FeaturesSqlHandler;
    protected $response;


    public function __construct(Guzzle $guzzle , FeaturesSqlHandler $FeaturesSqlHandler ,Response $response)
    {
        $this->Guzzle = $guzzle;
        $this->FeaturesSqlHandler  = $FeaturesSqlHandler;
        $this->response = $response;
    }

    public function addFeature($data){

        DB::beginTransaction();
        try{
            $result = $this->FeaturesSqlHandler->addFeature($data);

            var_dump($result);
            if(!$result)
                throw new \Exception('Feature not added in SQL');

            DB::commit();
            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }
    }

    public function updatefeaturebyPropertyId($data){

        DB::beginTransaction();
        try{
            $result = $this->FeaturesSqlHandler->updatefeaturebyPropertyId($data);


            var_dump($result);
            if(!$result)
                $this->response->not_found();

            DB::commit();
            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }
    }

    public function updateFeaturebyId($data){

        DB::beginTransaction();
        try{
            $result = $this->FeaturesSqlHandler->updateFeaturebyId($data);

            if(!$result){
                //dd($result);
                $this->response->not_found();
            }


            DB::commit();
            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }
    }

    public function ShowFeaturebyProperty_Id($data){

        try{
            $resultfromSQL  = $this->FeaturesSqlHandler->ShowFeaturebyProperty_Id($data);



            if(!$resultfromSQL)

                $this->response->not_found();

            return $resultfromSQL;

        } catch (\Exception $e) {
            var_dump($e);
        }

    }

    public function ShowFeaturebyId($data){

        try{
            $resultfromSQL  = $this->FeaturesSqlHandler->ShowFeaturebyProperty_Id($data);



            if(!$resultfromSQL)

                $this->response->record_notFound('Record Not Found ');

            return $resultfromSQL;

        } catch (\Exception $e) {
            var_dump($e);
        }

    }

}