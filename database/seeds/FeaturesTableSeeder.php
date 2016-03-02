<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Property as Property;
use App\Features as Features;
use App\FeaturesMongo as FeaturesMongo;

class FeaturesTableSeeder extends Seeder
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
        $properties = Property::all()->pluck('id')->toArray();
        for ($i = 0; $i < $limit; $i++) {
            $bedrooms = $faker->randomNumber(1);
            $bathrooms = $faker->randomNumber(1);
            $utilities = $faker->paragraph;
            $property_id = $properties[$i];

            // Insert In MySQL
            $feature = Features::create([
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'utilities' => $utilities,
                'property_id' => $property_id,
            ]);

            // Insert In Mongo
            $featureMongo = FeaturesMongo::create([
                '_id' => $feature->id,
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'utilities' => $utilities,
                'property_id' => $property_id,
            ]);
        }
    }
}
