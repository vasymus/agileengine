<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypesTableSeeder extends Seeder
{
    const CREDIT_ID = 1;
    const DEBIT_ID = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transaction_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table("transaction_types")->insert([
            [
                "id" => static::CREDIT_ID,
                "name" => "credit",
            ],
            [
                "id" => static::DEBIT_ID,
                "name" => "debit",
            ]
        ]);
    }
}
