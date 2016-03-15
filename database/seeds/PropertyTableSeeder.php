<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Location as Location;
use App\Property as Property;
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
        for ($i = 0; $i < $limit; $i++) {
            $title = $faker->streetSuffix;
            $price = $faker->randomNumber(3);
            $area = $faker->randomNumber(5);
            $status = 1;
            $description = $faker->paragraph;
            $purpose = $faker->randomElement(array('rent', 'sale'));
            $type = $faker->randomElement(array('house', 'apartment', 'open-house'));
            $category = $faker->randomElement(array('family', 'single-person', 'events'));
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
                'purpose' => $purpose,
                'type' => $type,
                'category' => $category,
                'image_url' => $image_url,
                'views' => $views,
                'loc_id' => $loc_id,
            ]);

            // Insert In Mongo
            $propertyMongo = PropertyMongo::create([
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
            ]);
        }
    }
}
