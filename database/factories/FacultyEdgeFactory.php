<?php

namespace Database\Factories;

use App\Models\Tansik\FacultyEdge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FacultyEdge>
 */
class FacultyEdgeFactory extends Factory
{
    protected $model = FacultyEdge::class;

    public function definition(): array
    {
        return [
            'section' => 'E',
            'TempName' => 't_'.str_replace('.', '_', uniqid('', true)),
            'year' => (int) $this->faker->numberBetween(2014, 2024),
            'edge' => $this->faker->randomFloat(2, 200, 500),
            'unifac_id' => null,
        ];
    }
}
