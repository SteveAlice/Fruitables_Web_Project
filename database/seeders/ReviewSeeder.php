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
            'rating'=> '5',
            'content' => 'This is comment',
            'created_at' => now(),
        ]);
    }
}
