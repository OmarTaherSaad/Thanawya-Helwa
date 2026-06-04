<?php

namespace Database\Factories;

use App\Models\Tansik\FacultyEdge;
use App\Support\Tansik\ThanawyaCoordinationSystem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FacultyEdge>
 */
class FacultyEdgeFactory extends Factory
{
    protected $model = FacultyEdge::class;

    public function definition(): array
    {
        $year = (int) $this->faker->numberBetween(2014, 2024);

        return [
            'section' => 'E',
            'TempName' => 't_'.str_replace('.', '_', uniqid('', true)),
            'year' => $year,
            'thanawya_system' => ThanawyaCoordinationSystem::resolveForMainStreamAdmissionYear($year),
            'edge' => $this->faker->randomFloat(2, 200, 500),
            'unifac_id' => null,
        ];
    }
}
