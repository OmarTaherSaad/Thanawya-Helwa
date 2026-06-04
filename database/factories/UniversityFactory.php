<?php

namespace Database\Factories;

use App\Models\Tansik\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<University>
 */
class UniversityFactory extends Factory
{
    protected $model = University::class;

    public function definition(): array
    {
        return [
            'name' => mb_substr($this->faker->company(), 0, 48),
            'type' => 'governmental',
            'logo' => null,
        ];
    }
}
