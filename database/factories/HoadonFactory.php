<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hoadon>
 */
class HoadonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'ngaydat' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'trangthai' => rand(0, 3), // 0: Hủy, 1: Chờ xử lý, 2: Đang giao, 3: Hoàn thành
            'sdtnhan' => $this->faker->phoneNumber,
            'diachigiaohang' => $this->faker->address,
            'user_id' => 1, // Mặc định, sẽ override ở Seeder
        ];
    }
}