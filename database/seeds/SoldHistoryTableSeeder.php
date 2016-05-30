<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Property as Property;
use App\Seller as Seller;
use App\Buyer as Buyer;
use App\SoldHistory as SoldHistory;
use App\SoldHistoryMongo as SoldHistoryMongo;

class SoldHistoryTableSeeder extends Seeder
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
        $sellers = Seller::all()->pluck('id')->toArray();
        $buyers = Buyer::all()->pluck('id')->toArray();
        for ($i = 0; $i < $limit; $i++) {
            $property_id = $faker->randomElement($properties);
            $seller_id = $faker->randomElement($sellers);
            $buyer_id = $faker->randomElement($buyers);
            $price_sqft = $faker->randomNumber(2);
            $total_price = $faker->randomNumber(5);
            $description = $faker->paragraph;


            $soldhistory = SoldHistory::create([
                'property_id' => $property_id,
                'seller_id' => $seller_id,
                'buyer_id' => $buyer_id,
                'price_sqft' => $price_sqft,
                'total_price' => $total_price,
                'description' => $description,
            ]);

            /*$soldhistoryMongo = SoldHistoryMongo::create([
                '_id' => $soldhistory->id,
                'property_id' => $property_id,
                'seller_id' => $seller_id,
                'buyer_id' => $buyer_id,
                'price_sqft' => $price_sqft,
                'total_price' => $total_price,
                'description' => $description,
            ]);*/
        }
    }
}
