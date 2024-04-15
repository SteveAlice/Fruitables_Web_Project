<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    for ($i = 1; $i <= 10; $i++) {
      DB::table('products')->insert([
        'name' => Str::random(10) . $i,
        // 'description' => 'default_description',
        'category_id' => rand(1, 5),
        'price' => rand(5, 100),
        'image' => 'fruite-item-' . rand(1, 6) . '.jpg',
        'stock' => rand(0, 100),
        // 'unit' => 'default_unit',
      ]);
    }
  }
}
