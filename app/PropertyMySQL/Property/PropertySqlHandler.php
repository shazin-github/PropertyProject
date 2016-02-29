<?php
namespace App\PropertyMySQL\Property;
use \DB;
use GuzzleHttp\Client as Guzzle;

class PropertySqlHandler{

    public function addproperty($data){

        $data['created_at'] = date('Y-m-d h:i:sa', strtotime('now'));

        $id = DB::table('property')->insertGetId($data);

        if($id)
            return $id;
        else
            return false;
    }

    public function updatebyID($data){

        $data['updated_at'] = date('Y-m-d h:i:sa' , strtotime('now') );

        $result = DB::table('property')->where('id' , $data['id'])->update($data);

        if($result){

            return $result;
        }else{

            return false;
        }

    }

    public function SearchByID($data){


        $result = DB::table('property')
            ->join('features' , 'property.id' , '=', 'features.property_id' )
            ->join('location', 'property.loc_id','=', 'location.id')
            ->select('*')
            ->where('property.id',$data['id'])
            ->get();



        if($result){

            return $result;
        }else{

            return false;
        }

    }

    public function SearchByStreet($data){

        $result = DB::table('property')
            ->join('features' , 'property.id' , '=', 'features.property_id' )
            ->join('location', 'property.loc_id','=', 'location.id')
            ->select('property.*','features.*','location.*')
            ->where('property.street',$data['street'])
            ->get();



        if($result){

            return $result;
        }else{

            return false;
        }


    }

    public function SearchWithPrice($data){

        $result = '';

        if(!$data['min'] && $data['max']  )
        {

            $result = DB::table('property')
                ->join('features' , 'property.id' , '=', 'features.property_id' )
                ->join('location', 'property.loc_id','=', 'location.id')
                ->select('property.*','features.*','location.*')
                ->whereBetween('price', [0, $data['max']])
                ->get();
        }

        if($data['min'] && !$data['max'])
        {

            $result = DB::table('property')
                ->join('features' , 'property.id' , '=', 'features.property_id' )
                ->join('location', 'property.loc_id','=', 'location.id')
                ->select('property.*','features.*','location.*')
                ->where('price','>=' ,$data['min'])
                ->get();
        }

        if( !$data['min'] && !$data['max'] )
        {

            $result = DB::table('property')
                ->join('features' , 'property.id' , '=', 'features.property_id' )
                ->join('location', 'property.loc_id','=', 'location.id')
                ->select('property.*','features.*','location.*')
                ->get();
        }else{
            if($data['min']<$data['max']){
                $result = DB::table('property')
                    ->join('features' , 'property.id' , '=', 'features.property_id' )
                    ->join('location', 'property.loc_id','=', 'location.id')
                    ->select('property.*','features.*','location.*')
                    ->whereBetween('price', [$data['min'], $data['max']])
                    ->get();
            }else {
                $result = DB::table('property')
                    ->join('features', 'property.id', '=', 'features.property_id')
                    ->join('location', 'property.loc_id', '=', 'location.id')
                    ->select('property.*', 'features.*', 'location.*')
                    ->whereBetween('price', [$data['max'], $data['min']])
                    ->get();
            }
        }

        if($result){

            return $result;
        }else{

            return false;
        }

    }

}