<?php
namespace App\PropertyMySQL\Buyer;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\Buyer\BuyerSqlHandler;

class Buyer{

    protected $Guzzle;
    protected $buyerSqlHandler;

    public function __construct(Guzzle $guzzle , BuyerSqlHandler $buyerSqlHandler)
    {
        $this->Guzzle = $guzzle;
        $this->buyerSqlHandler  = $buyerSqlHandler;
    }

    public function addBuyer($data){

        DB::beginTransaction();
        try{
            $result = $this->buyerSqlHandler->addBuyer($data);

            var_dump($result);
            if(!$result)
                throw new \Exception('Buyer not added in SQL');

            DB::commit();
            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }
    }

    public function ShowBuyerbyId($data){

        try{
            $resultfromSQL  = $this->buyerSqlHandler->ShowBuyerbyId($data);

            if(!$resultfromSQL)

                throw new \Exception('Buyer not found in SQL');

            return $resultfromSQL;

        } catch (\Exception $e) {

            var_dump($e);

        }
    }

    public function ShowBuyerbyProperty_Id($data){

        try{
            $resultfromSQL  = $this->buyerSqlHandler->ShowBuyerbyProperty_Id($data);

            if(!$resultfromSQL)

                throw new \Exception('Buyer not found in SQL');

            return $resultfromSQL;

        } catch (\Exception $e) {

            var_dump($e);

        }

    }

    public function ShowBuyerbyuser_Id($data){

        try{
            $resultfromSQL  = $this->buyerSqlHandler->ShowBuyerbyuser_Id($data);

            if(!$resultfromSQL)

                throw new \Exception('Buyer not found in SQL');

            return $resultfromSQL;

        } catch (\Exception $e) {

            var_dump($e);

        }

    }
}