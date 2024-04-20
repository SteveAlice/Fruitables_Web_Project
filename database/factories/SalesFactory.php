<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */
class SalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word, // Tên ngẫu nhiên
            'description' => $this->faker->sentence, // Mô tả ngẫu nhiên
            'percentage' => $this->faker->numberBetween(5, 50), // Phần trăm giảm giá ngẫu nhiên từ 5% đến 50%

        ];
    }
}