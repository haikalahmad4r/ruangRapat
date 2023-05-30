<?php

namespace Database\Factories;

use App\Models\PegawaiAbsen;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiAbsenFactory extends Factory
{
    protected $model = PegawaiAbsen::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'id_divisi' => $this->faker->numberBetween(1, 5),
            'jabatan' => $this->faker->jobTitle,
        ];
    }
}
