<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'title_personal' => $this->faker->title(),
            'title_on_team' => $this->faker->title(),
            'user_id' => $this->faker->randomElement(\App\User::all()->keys()),
            'joined_at' => $this->faker->date,
            'status' => $this->faker->randomElement(['founder', 'old', 'current']),
        ];
    }
}
