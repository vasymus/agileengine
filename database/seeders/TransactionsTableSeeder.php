<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transactions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $seeds = [];
        $range = 1000;
        $halfRange = $range / 2;
        $faker = Factory::create();

        foreach (range(1, $range) as $id) {
            $typeId = $id >= $halfRange ? TransactionTypesTableSeeder::DEBIT_ID : TransactionTypesTableSeeder::CREDIT_ID;

            $amount = $typeId === TransactionTypesTableSeeder::CREDIT_ID ? rand(500, 1000) : rand(100, 500);

            $date = $faker->dateTimeBetween("-1 month", "now");

            $seeds[] = [
                "account_id" => AccountsTableSeeder::TEST_ACCOUNT_ID,
                "type_id" => $typeId,
                "amount" => $amount,
                "created_at" => $date,
                "updated_at" => $date,
            ];
        }

        DB::table("transactions")->insert($seeds);
    }
}
