<?php
namespace App\PropertyMySQL\SaleHistory;
use \DB;
use GuzzleHttp\Client as Guzzle;

class SaleHistorySqlHandler{

    public function addSaleHistory($data){


        $data['created_at'] = date('Y-m-d h:i:sa', strtotime('now'));
        //dd($data);
        $id = DB::table('sold_history')->insertGetId($data);
        //dd($id);
        if($id)
            return $id;
        else
            return false;

    }

    public function ShowByid($data){

        $result = DB::table('sold_history')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;

    }

    public function ShowbyPropertyId($data){


        $result = DB::table('sold_history')->where('property_id', $data['property_id'])->get();
        if($result)
            return $result;
        else
            return false;

    }

    public function ShowbybuyerId($data){


        $result = DB::table('sold_history')->where('buyer_id', $data['buyer_id'])->get();
        if($result)
            return $result;
        else
            return false;

    }

    public function ShowSellerbysellerId($data){


        $result = DB::table('sold_history')->where('seller_id', $data['seller_id'])->get();
        if($result)
            return $result;
        else
            return false;

    }

}