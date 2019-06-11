<?php

use Illuminate\Database\Seeder;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TransactionsTableSeeder::class);
        $this->call(SellLogsTableSeeder::class);
    }

}

class TransactionsTableSeeder extends Seeder {
    public function  run()
    {
        DB::table('transactions')->delete();

        DB::table('transactions')->insert([
            ['id' => 1, 'code' => 'AAA', 'type' => 1, 'quantity' => 1000, 'available' => 0,'date' => '2019-01-01', 'created_at' => '2019-06-11 10:13:52','updated_at' => '2019-06-11 10:17:36'],
            ['id' => 2, 'code' => 'AAA', 'type' => 1, 'quantity' => 2000, 'available' => 500,'date' => '2019-01-04', 'created_at' => '2019-06-11 10:14:09','updated_at' => '2019-06-11 10:17:53'],
            ['id' => 4, 'code' => 'AAA', 'type' => 2, 'quantity' => 1000, 'available' => 0,'date' => '2019-01-10', 'created_at' => '2019-06-11 10:17:53','updated_at' => '2019-06-11 10:17:53'],
            ['id' => 3, 'code' => 'AAA', 'type' => 2, 'quantity' => 1500, 'available' => 0,'date' => '2019-01-08', 'created_at' => '2019-06-11 10:17:36','updated_at' => '2019-06-11 10:17:36'],
        ]);

    }
}

class SellLogsTableSeeder extends Seeder {
    public function run(){
        DB::table('sell_logs')->delete();

        DB::table('sell_logs')->insert([
            ['id' => 1, 'code' => 'AAA', 'sell_id' => 3, 'buy_id' => 1, 'quantity' => 1000, 'hold_time' => 7, 'created_at' => '2019-06-11 10:17:36', 'updated_at' => '2019-06-11 10:17:36'],
            ['id' => 2, 'code' => 'AAA', 'sell_id' => 3, 'buy_id' => 2, 'quantity' => 500, 'hold_time' => 4, 'created_at' => '2019-06-11 10:17:36', 'updated_at' => '2019-06-11 10:17:36'],
            ['id' => 3, 'code' => 'AAA', 'sell_id' => 4, 'buy_id' => 2, 'quantity' => 1000, 'hold_time' => 6, 'created_at' => '2019-06-11 10:17:53', 'updated_at' => '2019-06-11 10:17:53'],
        ]);
    }
}

