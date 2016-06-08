<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\PropertyCategory as PropertyCategory;

class PropertyCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $propCategoryArray = array(
            ['name'=> 'Single Person'],
            ['name' => 'Event'],
            ['name' => 'Family'],
            ['name' => 'Others']
            );

        foreach ($propCategoryArray as $key => $value) {

            // Insert In MySQL
            $propCategory = PropertyCategory::create([
                'name' => $value['name'],
            ]);
        }
    }
}
