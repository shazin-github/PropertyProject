<?php
namespace App\PropertyMySQL\Seller;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\Seller\SellerSqlHandler;

class Seller{

    protected $SellerSqlHandler;

    public function __construct(SellerSqlHandler $sellerhandler)
    {
        $this->SellerSqlHandler = $sellerhandler;
    }

    public function addSeller($data){

        DB::beginTransaction();
        try{
            $result = $this->SellerSqlHandler->addSeller ($data);


            DB::commit();
            return $result;
        } catch(\Exception $e){
            DB::rollback();
            var_dump($e);
        }
    }

    public function ShowSellerbyId($data){

        try{
            $resultfromSQL  = $this->SellerSqlHandler->ShowSellerbyId($data);

            return $resultfromSQL;

        } catch (\Exception $e) {

            var_dump($e);

        }
    }

    public function ShowSellerbyProperty_Id($data){

        try{
            $resultfromSQL  = $this->SellerSqlHandler->ShowSellerbyProperty_Id($data);

            return $resultfromSQL;

        } catch (\Exception $e) {

            var_dump($e);

        }

    }

    public function ShowSellerbyuser_Id($data){

        try{
            $resultfromSQL  = $this->SellerSqlHandler->ShowSellerbyuser_Id($data);

            return $resultfromSQL;

        } catch (\Exception $e) {

            var_dump($e);

        }

    }


}