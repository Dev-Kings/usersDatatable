<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $faker = Faker::create();
        $gender = $faker->randomElement(['male', 'female']);
    	foreach (range(1,2000) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name($gender),
                'phone_no' => $faker->phoneNumber,
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'email' => $faker->email,
                'password' => Hash::make('password'),            
            ]);
        }
    
    }
}
