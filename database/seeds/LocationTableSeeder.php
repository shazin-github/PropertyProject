<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Location as Location;
use App\LocationMongo as LocationMongo;

class LocationTableSeeder extends Seeder
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

        for ($i = 0; $i < $limit; $i++) {
            $address = $faker->address;
            $city = $faker->city;
            $zip = $faker->postcode;
            $state = $faker->state;
            $country = $faker->country;
            $latitude = $faker->latitude;
            $longitude = $faker->longitude;

            // Insert In MySQL
            $location = Location::create([
                'address' => $address,
                'city' => $city,
                'zip' => $zip,
                'state' => $state,
                'country' => $country,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

            // Insert In Mongo
            $locationMongo = LocationMongo::create([
                '_id' => $location->id,
                'address' => $address,
                'city' => $city,
                'zip' => $zip,
                'state' => $state,
                'country' => $country,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }
    }
}
