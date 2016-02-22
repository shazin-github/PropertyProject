<?php
namespace App\PropertyMySQL\Buyer;
use \DB;
use GuzzleHttp\Client as Guzzle;

class BuyerSqlHandler{

    public function addBuyer($data){
        //dd($data);
        $data['created_at'] = date('Y-m-d h:i:sa', strtotime('now'));
        //dd($data);
        $id = DB::table('buyer')->insertGetId($data);
        //dd($id);
        if($id)
            return $id;
        else
            return false;
    }

    public function ShowBuyerbyId($data){

        $result = DB::table('buyer')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;
    }

    public function ShowBuyerbyProperty_Id($data){

        $result[] = DB::table('buyer')->where('property_id', $data['property_id'])->get();
        if(!empty($result))
            return $result;
        else
            return false;
    }

    public function ShowBuyerbyuser_Id($data){

        $result[] = DB::table('buyer')->where('user_id', $data['user_id'])->get();

        if(!empty($result))

            return $result;

        else

            return false;
    }
}