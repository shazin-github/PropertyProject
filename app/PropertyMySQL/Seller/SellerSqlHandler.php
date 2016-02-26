<?php
namespace App\PropertyMySQL\Seller;
use \DB;
use GuzzleHttp\Client as Guzzle;

class SellerSqlHandler{

    public function addSeller($data){
        //dd($data);
        $data['created_at'] = date('Y-m-d h:i:sa', strtotime('now'));
        //dd($data);
        $id = DB::table('seller')->insertGetId($data);
        //dd($id);
        if($id)
            return $id;
        else
            return false;
    }

    public function ShowSellerbyId($data){

        $result[] = DB::table('seller')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;
    }

    public function ShowSellerbyProperty_Id($data){

        $result[] = DB::table('seller')->where('property_id', $data['property_id'])->get();
        if($result)
            return $result;
        else
            return false;
    }

    public function ShowSellerbyuser_Id($data){

        $result[] = DB::table('seller')->where('user_id', $data['user_id'])->get();

        if($result)
            return $result;
        else
            return false;
    }

}