<?php

namespace Database\Factories;

use App\Models\Tansik\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faculty>
 */
class FacultyFactory extends Factory
{
    protected $model = Faculty::class;

    public function definition(): array
    {
        return [
            'name' => mb_substr($this->faker->word().' '.$this->faker->word(), 0, 95),
            'common_name' => null,
            'sections_allowed' => 'E',
        ];
    }
}
