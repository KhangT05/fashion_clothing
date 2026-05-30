<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sanpham>
 */
class SanphamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;
        return [
            'tensp' => $name,
            'hinhanh' => 'https://via.placeholder.com/150', // Ảnh giả
            'soluong' => rand(10, 100),
            'giaban' => rand(100, 1000) * 1000, // Giá từ 100k đến 1tr
            'slug' => Str::slug($name),
            'mota' => $this->faker->text(200),
            'bienthe_id' => 1, // Giả định ID = 1
            'category_id' => 1,
            'thuonghieu_id' => 1,
        ];
    }
}