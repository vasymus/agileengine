<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeeder extends Seeder
{
    const TEST_ACCOUNT_ID = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('accounts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table("accounts")->insert([
            [
                "id" => static::TEST_ACCOUNT_ID,
                "user_id" => UsersTableSeeder::TEST_USER_ID,
            ]
        ]);
    }
}
