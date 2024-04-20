<?php

namespace Database\Factories;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Lấy một id của một Discount ngẫu nhiên từ cơ sở dữ liệu
        $salesId = Sales::inRandomOrder()->first()->id;

        return [
            'name' => $this->faker->word,
            'desc' => $this->faker->sentence,
            'SKU' => $this->faker->unique()->numerify('SKU#####'),
            'category' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'image' => $this->faker->imageUrl(),
            'sales_id' => $salesId, // Liên kết Product với một Discount tồn tại
        ];
    }
}
