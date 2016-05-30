<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Location as Location;
use App\Property as Property;
use App\PropertyCategory as PropertyCategory;
use App\PropertyPurpose as PropertyPurpose;
use App\PropertyType as PropertyType;
use App\PropertyMongo as PropertyMongo;

class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $limit = 30;
        $locations = Location::all()->pluck('id')->toArray();
        $propCategory = PropertyCategory::all()->pluck('id')->toArray();
        $propPurpose = PropertyPurpose::all()->pluck('id')->toArray();
        $propType = PropertyType::all()->pluck('id')->toArray();
        for ($i = 0; $i < $limit; $i++) {
            $title = $faker->streetSuffix;
            $price = $faker->randomNumber(3);
            $area = $faker->randomNumber(5);
            $status = 1;
            $description = $faker->paragraph;
            $purpose_id = $faker->randomElement($propPurpose);
            $type_id = $faker->randomElement($propType);
            $category_id = $faker->randomElement($propCategory);
            $areatype = $faker->randomElement(array('sqft', 'marla', 'kenal'));
            $image_url = $faker->imageUrl('640', '480', 'city', true, 'Faker');
            $views = $faker->randomNumber(3);
            $loc_id = $faker->randomElement($locations);

            // Insert In MySQL
            $property = Property::create([
                'title' => $title,
                'price' => $price,
                'area' => $area,
                'status' => $status,
                'description' => $description,
                'area_type'=>$areatype,
                'prop_purpose_id' => $purpose_id,
                'prop_type_id' => $type_id,
                'prop_category_id' => $category_id,
                'image_url' => $image_url,
                'views' => $views,
                'loc_id' => $loc_id,
            ]);

            // Insert In Mongo
            /*$propertyMongo = PropertyMongo::create([
                '_id' => $property->id,
                'title' => $title,
                'price' => $price,
                'area' => $area,
                'status' => $status,
                'description' => $description,
                'purpose' => $purpose,
                'type' => $type,
                'category' => $category,
                'image_url' => $image_url,
                'views' => $views,
                'loc_id' => $loc_id
            ]);*/
        }
    }
}
