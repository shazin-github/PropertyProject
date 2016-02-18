<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PropertyTableSeeder::class);
        $this->call(FeaturesTableSeeder::class);
        $this->call(SellerTableSeeder::class);
        $this->call(BuyerTableSeeder::class);
        $this->call(AgentTableSeeder::class);
        $this->call(WatchlistTableSeeder::class);
        $this->call(SoldHistoryTableSeeder::class);
    }
}
