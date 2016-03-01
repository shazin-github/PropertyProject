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
    public function showproperty(){

        $result = DB::table('property')
            ->join('features' , 'property.id' , '=', 'features.property_id' )
            ->join('location', 'property.loc_id','=', 'location.id')
            ->select('property.*','features.*','location.*')
            ->where('property.status',1)
            ->get();



        if($result){

            return $result;
        }else{

            return false;
        }

    }

    public  function  livesearch($data){


        $longitude = $data['longitude'];

        $latitude = $data['latitude'];

        $purpose = $data['purpose'];

        $sql_purpose = '';

        if($purpose != null){

            $sql_purpose = "And property.purpose like '$purpose'";

        }else{

            $sql_purpose = "And ( property.purpose like 'rent' OR property.purpose like 'sale' )";

        }


        $bed = $data['bedroom'];

        if($bed != null){

            $sql_bed = " and features.bedrooms = $bed";

        }else{

            $sql_bed = "And features.bedrooms > 0";

        }

        $bath = $data['bathroom'];

        if($bath != null){

            $sql_bath = "And features.bathrooms = $bath";

        }else{

            $sql_bath = "And features.bathrooms > 0";

        }



        $loc_ids = '';

        if($latitude != null && $longitude != null){

            //dd('test');

            $results = DB::select( DB::raw("SELECT
                                              id, ROUND(
                                                6371 * acos (
                                                  cos ( radians(:lat) )
                                                  * cos( radians( latitude ) )
                                                  * cos( radians( longitude ) - radians(:long) )
                                                  + sin ( radians(:lat1) )
                                                  * sin( radians( latitude ) )
                                                )
                                              ) AS distance
                                            FROM location
                                            HAVING distance < 30
                                            ORDER BY distance"), [
                'lat' => $latitude,
                'lat1' => $latitude,
                'long'=> $longitude,
            ]);

          foreach($results as $res){

                $loc_ids[] = $res->id;

            }

        }

        $loc_id = implode(',', $loc_ids);

        $properties = DB::select(
            DB::raw("select property.* , features.* , location.* from property
                    INNER JOIN features on property.id=features.property_id $sql_bath $sql_bed
                    INNER JOIN location on property.loc_id= location.id
                    WHERE property.loc_id IN ($loc_id) $sql_purpose ")
//            ,[
//                //'SQLBED'=> $loc_id,
//                //'bed' =>$bed,
//                //'bathrooms'=> $bath,
//                'purpose'=>$purpose,
//            ]
        );

        return $properties;

    }

}