<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class Product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
       DB::table('product')->insert([
         'name' => 'chuối',
         'text' => 'trái cây ngon bổ rẻ tốt nhất',
         'SKU'=> 'A-B-M-GREEN',
         'category' => 'trái cây',
         'price' =>24,
         'discount_id' => 0,
       ]);
       DB::table('product')->insert([
        'name' => 'cam',
        'text' => 'trái cây ngon bổ rẻ tốt nhất',
        'SKU'=> 'A-G-M-GREEN',
        'category' => 'trái cây',
        'price' =>50,
        'discount_id' => 0,
      ]);
      DB::table('product')->insert([
        'name' => 'Bưởi',
        'text' => 'trái cây ngon bổ rẻ tốt nhất',
        'SKU'=> 'A-G-M-GREEN',
        'category' => 'trái cây',
        'price' =>60,
        'discount_id' => 0,
      ]);
    }
}
