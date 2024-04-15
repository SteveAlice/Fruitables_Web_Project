<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed = ['Fruits','Vegetables','Meats','Grains','Nuts','Seeds','Legumes','Seafood','Sweets','Snacks'];
        foreach ($seed as $key) {
            \DB::table('categories')->insert([
                'name' => $key
            ]);

        }

    }
}
