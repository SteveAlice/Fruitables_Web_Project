<?php

namespace Database\Seeders;

use App\Models\Sales;
use Database\Factories\SalesFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->truncate();

        // Tạm ngừng các sự kiện của model Sales
        Sales::withoutEvents(function () {
            // Sử dụng SalesFactory::new() để tạo và lưu bản ghi Sales vào cơ sở dữ liệu
            SalesFactory::new()->count(5)->create();
        });
    }
}
