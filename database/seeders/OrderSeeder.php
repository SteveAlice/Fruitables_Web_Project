<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
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

        for ($i=1; $i < 5; $i++) { 
            \DB::table('orders')->insert([
                'user_id' => 1,
                'order_date' => now(),
                'total_amount' => 0.00,
                'shipping'=> 3.00,
            ]);
        }
        for ($i=1; $i < 5; $i++) { 
            \DB::table('orders')->insert([
                'user_id' => 1,
                'order_date' => now(),
                'total_amount' => 100.00,
                'status' => 'shipping',
                'shipping'=> 3.00,
            ]);
        }
        for ($i=1; $i < 5; $i++) { 
            \DB::table('orders')->insert([
                'user_id' => 1,
                'order_date' => now(),
                'total_amount' => 230.00,
                'status' => 'delivered',
                'shipping'=> 3.00,
            ]);
        }
        for ($i=1; $i < 5; $i++) { 
            \DB::table('orders')->insert([
                'user_id' => 1,
                'order_date' => now(),
                'total_amount' => 230.00,
                'status' => 'processing',
                'shipping'=> 3.00,
            ]);
        }
    }
}
