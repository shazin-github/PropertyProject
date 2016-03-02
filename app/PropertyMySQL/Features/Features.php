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

            return $resultfromSQL;

        } catch (\Exception $e) {
            var_dump($e);
        }

    }

    public function ShowFeaturebyId($data){

        try{
            $resultfromSQL  = $this->FeaturesSqlHandler->ShowFeaturebyProperty_Id($data);

            return $resultfromSQL;

        } catch (\Exception $e) {
            var_dump($e);
        }

    }

    public function ShowByNumberOfBedrooms($data){

        try{

            $result = $this->FeaturesSqlHandler->ShowByNumberOfBedrooms($data);

            return $result;
        }catch(\Exception $e){

            var_dump($e);
        }

    }

    public function ShowByNumberOfBathrooms($data){

        try{

            $result = $this->FeaturesSqlHandler->ShowByNumberOfBathrooms($data);

            return $result;
        }catch(\Exception $e){

            var_dump($e);
        }

    }


    public function ShowWithBathAndBedroomd($data){

        try{

            $result = $this->FeaturesSqlHandler->ShowWithBathAndBedroomd($data);

            return $result;
        }catch(\Exception $e){

            var_dump($e);
        }

    }

}