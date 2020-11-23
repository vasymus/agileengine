<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    const TEST_USER_ID = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Factory::create();

        DB::table('users')->insert([
            [
                "id" => static::TEST_USER_ID,
                "email" => $faker->safeEmail,
                "name" => $faker->name,
                "password" => Hash::make("secret"),
            ]
        ]);
    }
}
