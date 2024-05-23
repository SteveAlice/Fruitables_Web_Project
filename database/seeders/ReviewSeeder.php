<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('reviews')->insert([
            'user_id' => 1,
            'product_id' => 1,
            'rating'=> '4',
            'content' => 'This is review',
            'created_at' => now(),
        ]);
        for ($i=2; $i < 4; $i++) { 
            \DB::table('reviews')->insert([
                'user_id' => 1,
                'product_id' => 1,
                'rating'=> '0',
                'content' => 'This is comment',
                'created_at' => now(),
            ]);
        }
    }
}
