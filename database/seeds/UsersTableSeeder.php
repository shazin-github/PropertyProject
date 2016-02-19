<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Location as Location;
use App\User as User;
use App\UsersMongo as UserMongo;

class UsersTableSeeder extends Seeder
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
            $username = $faker->userName;
            $firstname = $faker->firstName;
            $lastname = $faker->lastName;
            $email = $faker->safeEmail;
            $password = $faker->password;
            $phone = $faker->phoneNumber;
            $loc_id = $faker->randomElement($locations);

            // Insert In MySQL
            $user = User::create([
                'username' => $username,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'loc_id' => $loc_id,
            ]);

            // Insert In Mongo
            $userMongo = UserMongo::create([
                '_id' => $user->id,
                'username' => $username,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'loc_id' => $loc_id,
            ]);
        }
    }
}
