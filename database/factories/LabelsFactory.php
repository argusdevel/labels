<?php

namespace Database\Factories;

use App\Models\Labels;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Labels>
 */
class LabelsFactory extends Factory
{
    protected $model = Labels::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Str::random(15)
        ];
    }
}
