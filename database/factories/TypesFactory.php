<?php

namespace Database\Factories;

use App\Models\Types;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypesFactory extends Factory
{
    protected $model = Types::class;

    public function definition()
    {
        return [
            'name' => 'Movie',
        ];
    }
}
