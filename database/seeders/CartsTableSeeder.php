<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('carts')->insert([
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'unit_price' => 23.23,
        ]);
        \DB::table('carts')->insert([
            'order_id' => 1,
            'product_id' => 2,
            'quantity' => 2,
            'unit_price' => 12.23,
        ]);
    }
}
