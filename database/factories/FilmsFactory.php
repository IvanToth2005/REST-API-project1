<?php

namespace Database\Factories;

use App\Models\Films;
use App\Models\Directors;
use App\Models\Types;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmsFactory extends Factory
{
    protected $model = Films::class;

    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(2),
            'director_id' => Directors::factory(),
            'type_id' => Types::factory(),
            'release_date' => $this->faker->date(),
            'description' => $this->faker->paragraph(),
            'length' => $this->faker->numberBetween(60, 180), 
        ];
    }
}
