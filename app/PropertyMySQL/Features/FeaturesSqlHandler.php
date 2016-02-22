<?php
namespace App\PropertyMySQL\Features;
use \DB;
use GuzzleHttp\Client as Guzzle;

class FeaturesSqlHandler{

    public function addFeature($data){
        //dd($data);
        $data['created_at'] = date('Y-m-d h:i:sa', strtotime('now'));
        //dd($data);
        $id = DB::table('features')->insertGetId($data);
        //dd($id);
        if($id)
            return $id;
        else
            return false;
    }

    public function updatefeaturebyPropertyId($data){

        $data['updated_at'] = date('Y-m-d', strtotime('now'));
        $result = DB::table('features')->where('property_id', $data['property_id'])->update($data);
        if($result)
            return $result;
        else
            return false;

    }

    public function updateFeaturebyId($data){

        $data['updated_at'] = date('Y-m-d', strtotime('now'));
        $result = DB::table('features')->where('id', $data['id'])->update($data);

        var_dump($result);

        //dd($result);

        if($result < 1 )

            return false;
        else
            return $result;

    }

    public function ShowFeaturebyProperty_Id($data){

        $result[] = DB::table('features')->where('property_id', $data['property_id'])->get();
        if($result)
            return $result;
        else
            return false;
    }

    public function ShowFeaturebyId($data){

        $result[] = DB::table('features')->where('id', $data['id'])->get();
        if($result)
            return $result;
        else
            return false;
    }
}