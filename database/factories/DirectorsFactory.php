<?php

namespace Database\Factories;

use App\Models\Directors;
use Illuminate\Database\Eloquent\Factories\Factory;

class DirectorsFactory extends Factory
{
    protected $model = Directors::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
