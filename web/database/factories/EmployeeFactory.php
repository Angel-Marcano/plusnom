<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    protected $chargues = ['Jefe', 'Contratado', 'Fijo', 'Director'];

    protected $divisions = [
        'Recursos Humanos',
        'Servicios Públicos',
        'Sumat',
        'Dirección de Tecnología e Informática'
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document' => $this->faker->numerify('#######'),
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'chargue' => $this->chargues[array_rand($this->chargues)],
            'division' => $this->divisions[array_rand($this->divisions)],
            'admission_date' => $this->faker->date('Y-m-d', 'now')
        ];
    }
}
