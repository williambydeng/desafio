<?php

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Livro;

class LivroFactory extends Factory
{
    protected $model = Livro::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
            'usuario_publicador_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'indices' => function () {
                return \App\Models\Indices::factory()->create();
            },
        ];
    }
}
