<?php

namespace Database\Factories;

use App\Models\Tansik\Faculty;
use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UniFac>
 */
class UniFacFactory extends Factory
{
    protected $model = UniFac::class;

    public function definition(): array
    {
        return [
            'name' => 'كلية '.$this->faker->words(2, true),
            'address' => null,
            'university_id' => University::factory(),
            'faculty_id' => Faculty::factory(),
            'slug' => null,
            'meta_description' => null,
            'is_active' => true,
        ];
    }
}
