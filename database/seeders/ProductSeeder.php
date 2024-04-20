<?php

namespace Database\Seeders;

use App\Models\Sales;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Xóa dữ liệu cũ trong bảng product
        Product::truncate();

        // Lấy một sales ngẫu nhiên từ cơ sở dữ liệu
        $sales = Sales::inRandomOrder()->first();

        // Tạo 5 bản ghi sản phẩm sử dụng ProductFactory
        Product::withoutEvents(function () use ($sales) {
            ProductFactory::new()->count(5)->create([
                'sales_id' => $sales ? $sales->id : null, // Kiểm tra nếu có sales thì gán sales_id, ngược lại gán null
            ]);
        });

         // Thêm sản phẩm cụ thể vào cơ sở dữ liệu
        Product::create([
            'name' => 'Chuối',
            'desc' => 'Trái cây ngon bổ rẻ tốt nhất',
            'SKU' => 'A-B-M-GREEN',
            'category' => 'Trái cây',
            'price' => 24,
            'image' => 'public/img/fruite-item-1.jpg',
            'sales_id' => $sales ? $sales->id : null, // Kiểm tra nếu có sales thì gán sales_id, ngược lại gán null
        ]);
    }
}
