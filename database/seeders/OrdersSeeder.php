<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('orders')->insert([
            'user_id' => 1,
            'order_date' => now(),
            'total_amount' => 100.00,
            'shipping'=> 3.00,
        ]);
    }
}
