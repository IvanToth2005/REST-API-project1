<?php

namespace Database\Factories;

use App\Models\Actors;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActorsFactory extends Factory
{
    protected $model = Actors::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'image' => 'default.png'
        ];
    }
}
