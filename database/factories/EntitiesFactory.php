<?php

namespace Database\Factories;

use App\Models\Entities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entities>
 */
class EntitiesFactory extends Factory
{
    protected $model = Entities::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['user', 'company', 'website']),
            'title' => Str::random(15),
            'labels' => null
        ];
    }
}
