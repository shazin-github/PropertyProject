<?php
namespace App\PropertyMySQL\SaleHistory;
use \DB;
use GuzzleHttp\Client as Guzzle;

use App\PropertyMySQL\SaleHistory\SaleHistorySqlHandler;
class SaleHistory{

    protected $SaleHistorySqlHandler;

    public function __construct(SaleHistorySqlHandler $saleHistory)
    {
        $this->SaleHistorySqlHandler = $saleHistory;
    }


    public function addSaleHistory($data){

        DB::beginTransaction();
        try{
            $result = $this->SaleHistorySqlHandler->addSaleHistory($data);

            DB::commit();
            return $result;
        } catch(\Exception $e){
            DB::rollback();

        }
    }


    public function ShowByid($data){

        try{
            $resultfromSQL  = $this->SaleHistorySqlHandler->ShowByid($data);

            return $resultfromSQL;

        } catch (\Exception $e) {

        }

    }


    public function ShowbyPropertyId($data){

        try{
            $resultfromSQL  = $this->SaleHistorySqlHandler->ShowbyPropertyId($data);

            return $resultfromSQL;

        } catch (\Exception $e) {

        }

    }


    public function ShowbybuyerId($data){

        try{
            $resultfromSQL  = $this->SaleHistorySqlHandler->ShowbybuyerId($data);

            return $resultfromSQL;

        } catch (\Exception $e) {

        }

    }


    public function ShowSellerbysellerId($data){

        try{
            $resultfromSQL  = $this->SaleHistorySqlHandler->ShowSellerbysellerId($data);

            return $resultfromSQL;

        } catch (\Exception $e) {

        }

    }



}