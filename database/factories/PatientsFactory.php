<?php

namespace Database\Factories;

use App\Models\Patients;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PatientsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patients::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name'     => $this->faker->name,
            'birthday'      => $this->faker->dateTimeThisCentury->format('Y-m-d'),
            'genre'         => 'F',
            'name_father'   => $this->faker->name,
            'name_mother'   => $this->faker->name,
            'name_mentor'   => $this->faker->name,
            'helper_contact'=> $this->faker->name,
            'helper_email'  => $this->faker->unique()->safeEmail,
            'code_patient'  => Str::random(10),
            'user_id'       => 1
        ];
    }
}
