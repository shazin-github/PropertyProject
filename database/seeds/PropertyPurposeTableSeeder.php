<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\PropertyPurpose as PropertyPurpose;

class PropertyPurposeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propPurposeArray = array(
            ['name'=> 'rent'],
            ['name' => 'for sale'],
            );

        foreach ($propPurposeArray as $key => $value) {

            // Insert In MySQL
            $propPurpose = PropertyPurpose::create([
                'name' => $value['name'],
            ]);
        }
    }
}
