<?php
namespace App\PropertyMySQL\Property;
use \DB;
use GuzzleHttp\Client as Guzzle;

class PropertySqlHandler{

    public function addproperty($data){

        $data['created_at'] = date('Y-m-d h:i:sa', strtotime('now'));

        $data['updated_at'] = date('Y-m-d h:i:sa', strtotime('now'));

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
            ->select('property.id', 'property.loc_id', 'property.prop_type_id', 'property.prop_purpose_id', 'property.prop_category_id', 'property.title', 'property.price', 'property.area', 'property.area_type', 'property.description', 'property.image_url', 'property.views', 'property.status as status','property.created_at', 'property.updated_at', 'location.address','location.city', 'location.zip', 'location.state','location.country', 'location.latitude', 'location.longitude', 'features.property_id', 'features.bedrooms', 'features.bathrooms', 'features.utilities')
            ->where('property.id',$data['id'])
            ->get();



        if($result){
            $p_id = $result[0]->prop_purpose_id;
            $res = DB::table('property_purpose')->select('property_purpose.name')->where('id',$p_id)->get();
            $result[0]->prop_purpose_id = $res[0]->name;

            return $result;
        }else{

            return false;
        }

    }

    public function SearchByCity($data){

        $result = DB::table('property')
            ->join('features' , 'property.id' , '=', 'features.property_id' )
            ->join('location', 'property.loc_id','=', 'location.id')
            ->select('property.id', 'property.loc_id', 'property.prop_type_id', 'property.prop_purpose_id', 'property.prop_category_id', 'property.title', 'property.price', 'property.area', 'property.area_type', 'property.description', 'property.image_url', 'property.views', 'property.status as status','property.created_at', 'property.updated_at', 'location.address','location.city', 'location.zip', 'location.state','location.country', 'location.latitude', 'location.longitude', 'features.property_id', 'features.bedrooms', 'features.bathrooms', 'features.utilities')
            ->where('location.city',$data['city'])
            ->get();



        if($result){
            $p_id = $result[0]->prop_purpose_id;
            $res = DB::table('property_purpose')->select('property_purpose.name')->where('id',$p_id)->get();
            $result[0]->prop_purpose_id = $res[0]->name;

            return $result;
        }else{

            return false;
        }


    }
    
    public function SearchWithUser($data){

        $result = DB::table('seller')
            ->join('property' , 'property.id' , '=', 'seller.property_id' )
            ->join('features' , 'features.property_id' , '=', 'seller.property_id' )
            ->join('location' , 'location.id' , '=', 'property.loc_id' )
            ->where('seller.user_id', $data['user_id'])
            ->get();
        
        if($result){
            $results = array();

            foreach($result as $mod_res){
                $p_id = $mod_res->prop_purpose_id;
                //dd($p_id);
                $prop_purpose_id = DB::table('property_purpose')->select('property_purpose.name')->where('id',$p_id)->get();
                //dd($prop_purpose_id[0]->name);
                $mod_res->prop_purpose_id = $prop_purpose_id[0]->name;
                $results[] = $mod_res;
            }

            return $results;
        }else{
            return false;
        }

    }
    public function SearchWithPrice($data){

        $result = '';

        if(!$data['min'] && $data['max']  ) // if only min price is given
        {

            $result = DB::table('property')
                ->join('features' , 'property.id' , '=', 'features.property_id' )
                ->join('location', 'property.loc_id','=', 'location.id')
                ->select('property.*','features.*','location.*')
                ->whereBetween('price', [0, $data['max']])
                ->get();
        }

        if($data['min'] && !$data['max']) // if only max price is given
        {

            $result = DB::table('property')
                ->join('features' , 'property.id' , '=', 'features.property_id' )
                ->join('location', 'property.loc_id','=', 'location.id')
                ->select('property.*','features.*','location.*')
                ->where('price','>=' ,$data['min'])
                ->get();
        }

        if( !$data['min'] && !$data['max'] ) //if both are not given
        {

            $result = DB::table('property')
                ->join('features' , 'property.id' , '=', 'features.property_id' )
                ->join('location', 'property.loc_id','=', 'location.id')
                ->select('property.*','features.*','location.*')
                ->get();
        }else{
            if($data['min']<$data['max']){ // if both are given then check either max is smaller then min or not
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
        
        //propertty_purpose
        $purpose = (isset($data['purpose']) && !empty($data['purpose'])) ? $data['purpose'] : null;

        $sql_purpose = '';

        if($purpose != null){



            $p = DB::table('property_purpose')->select('property_purpose.id')->where('name',$purpose)->get();

            $sql_purpose = "And property.prop_purpose_id =".$p[0]->id;

        }else{

            $sql_purpose = "And ( property.prop_purpose_id > 0 )";

        }


        $bed = (isset($data['bedroom']) && !empty($data['bedroom'])) ? $data['bedroom'] : null;

        if($bed != null){

            $sql_bed = " and features.bedrooms = $bed";

        }else{

            $sql_bed = "And features.bedrooms > 0";

        }

        $bath = (isset($data['bathroom']) && !empty($data['bathroom'])) ? $data['bathroom']: null;

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
            DB::raw("select property.id, property.loc_id, property.prop_type_id, property.prop_purpose_id, property.prop_category_id, property.title, property.price, property.area, property.area_type,property.description,property.image_url,property.views, property.created_at, property.updated_at, features.bedrooms, features.bathrooms,features.utilities , location.address, location.city, location.zip, location.state, location.country, location.latitude, location.longitude from property
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

        //return $properties;
        $results = array();

        foreach($properties as $mod_res){

            $t_id = $mod_res->prop_type_id;
            $p_id = $mod_res->prop_purpose_id;
            $c_id = $mod_res->prop_category_id;

            $prop_type_id = DB::table('property_type')->select('property_type.name')->where('id', $t_id)->get();
            $prop_purpose_id = DB::table('property_purpose')->select('property_purpose.name')->where('id',$p_id)->get();
            $prop_category_id = DB::table('property_category')->select('property_category.name')->where('id',$c_id)->get();

            $mod_res->prop_type_id = $prop_type_id[0]->name;
            $mod_res->prop_purpose_id = $prop_purpose_id[0]->name;
            $mod_res->prop_category_id = $prop_category_id[0]->name;

            $results[] = $mod_res;
        }

        return $results;

    }

    public function SearchWithMaxPrice($data){

        $result = DB::table('property')
            ->where('price','<=', $data['max'])
            ->get();
        
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    public function ShowRecent(){

        $result = DB::table('property')
            ->join('features' , 'property.id' , '=', 'features.property_id' )
            ->join('location', 'property.loc_id','=', 'location.id')
            ->select('property.*','features.*','location.*')
            ->where('property.status',1)
            ->orderBy('property.created_at', 'desc')
            ->take(4)
            ->get();


        if($result){

            $results = array();

            foreach($result as $mod_res){
                $p_id = $mod_res->prop_purpose_id;
                //dd($p_id);
                $prop_purpose_id = DB::table('property_purpose')->select('property_purpose.name')->where('id',$p_id)->get();
                //dd($prop_purpose_id[0]->name);
                $mod_res->prop_purpose_id = $prop_purpose_id[0]->name;
                $results[] = $mod_res;
            }

            return $results;
        }else{

            return false;
        }

    }

    public function SearchWithMinPrice($data)
    {

        $result = DB::table('property')
            ->where('price', '>=', $data['min'])
            ->get();

        if ($result) {
            return $result;
        } else {
            return false;
        }

    }

    public function ShowMostViewed(){

        $result = DB::table('property')
            ->join('features' , 'property.id' , '=', 'features.property_id' )
            ->join('location', 'property.loc_id','=', 'location.id')
            ->select('property.*','features.*','location.*')
            ->where('property.status',1)
            ->orderBy('property.views', 'desc')
            ->take(8)
            ->get();


        if($result){

            $results = array();

            foreach($result as $mod_res){
                $p_id = $mod_res->prop_purpose_id;
                //dd($p_id);
                $prop_purpose_id = DB::table('property_purpose')->select('property_purpose.name')->where('id',$p_id)->get();
               //dd($prop_purpose_id[0]->name);
                $mod_res->prop_purpose_id = $prop_purpose_id[0]->name;
                $results[] = $mod_res;
            }

            return $results;
        }else{

            return false;
        }

    }

    public function updateviews($data){

        $result = DB::table('property')
            ->where('id',$data['id'])
            ->increment('views');

        if($result){

            return $result;
        }else{

            return false;
        }


    }

}