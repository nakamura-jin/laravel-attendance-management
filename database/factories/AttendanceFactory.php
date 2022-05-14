<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => 2022,
            'month' => $this->faker->numberBetween(5, 6),
            'date' => $this->faker->numberBetween(1, 30),
            'start_time' => '9:00',
            'breake_time' => '1:00',
            'end_time' => '18:00',
            'remarks' => $this->faker->realText(),
            'user_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
