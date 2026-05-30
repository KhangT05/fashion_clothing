<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CtHoadon>
 */
class CtHoadonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'soluong' => rand(1, 5),
            'trangthai' => 1,
            'dongia' => 0, // Sẽ tính toán lại ở Seeder
            'thanhtien' => 0,
            'hoadon_id' => 1,
            'sanpham_id' => 1,
        ];
    }
}