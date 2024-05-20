<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
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
        ]);
        \DB::table('carts')->insert([
            'order_id' => 1,
            'product_id' => 2,
            'quantity' => 2,
        ]);

        for ($i=2; $i < 13; $i++) { 
            \DB::table('carts')->insert([
                'order_id' => $i,
                'product_id' => $i,
                'quantity' => 2,
            ]);
        }
    }
}
