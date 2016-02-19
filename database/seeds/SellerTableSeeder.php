<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Property as Property;
use App\User as User;
use App\Seller as Seller;
use App\SellerMongo as SellerMongo;

class SellerTableSeeder extends Seeder
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
        $users = User::all()->pluck('id')->toArray();
        for ($i = 0; $i < $limit; $i++) {
            $property_id = $faker->randomElement($properties);
            $user_id = $faker->randomElement($users);

            // Insert In MySQL
            $seller = Seller::create([
                'property_id' => $property_id,
                'user_id' => $user_id,
            ]);

            // Insert In Mongo
            $sellerMongo = SellerMongo::create([
                '_id' => $seller->id,
                'property_id' => $property_id,
                'user_id' => $user_id,
            ]);
        }
    }
}
