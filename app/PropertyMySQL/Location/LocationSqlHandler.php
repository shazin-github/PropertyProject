<?php
namespace App\PropertyMySQL\Location;
use \DB;
use GuzzleHttp\Client as Guzzle;

class LocationSqlHandler{

    public function addlocation($data){
        //dd($data);
        $data['created_at'] = date('Y-m-d', strtotime('now'));
        //dd($data);
        $id = DB::table('location')->insertGetId($data);
        //dd($id);
        if($id)
            return $id;
        else
            return false;
    }

    public function updateLocation($data){
        $data['updated_at'] = date('Y-m-d', strtotime('now'));
        $result = DB::table('location')->where('id', $data['id'])->update($data);
        if($result)
            return $result;
        else
            return false;
    }
    public function ShowLocationbyId($data){

        $result = DB::table('location')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;
    }

    public function DisabledById($id){

        $res = DB::table('location')->where('id', $id)->first();

        $result =  (array) $res;

        $status = $result['status'] ;

        if($status == 1) {

            $result['status'] = 0;

        }else {

            $result['status'] = 1;

        }

        $result['updated_at'] = date('Y-m-d', strtotime('now'));

        $data = DB::table('location')->where('id', $id)->update($result);

        if($data)

            return $data;

        else

            return false;

    }


}