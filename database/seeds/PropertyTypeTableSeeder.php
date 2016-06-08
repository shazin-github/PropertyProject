<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\PropertyType as PropertyType;

class PropertyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propTypeArray = array(
            ['name'=> 'Home'],
            ['name' => 'Plot'],
            ['name' => 'Commercial'],
            ['name' => 'Appartment'],
            );

        foreach ($propTypeArray as $key => $value) {

            // Insert In MySQL
            $propType = PropertyType::create([
                'name' => $value['name'],
            ]);
        }
    }
}
