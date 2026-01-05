<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'last_name'   => $this->faker->lastName(),
            'first_name'  => $this->faker->firstName(),
            'gender'      => $this->faker->numberBetween(1, 2),
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => '090' . $this->faker->numberBetween(10000000, 99999999),
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'category_id' => $this->faker->numberBetween(1, 5),
            'detail'      => $this->faker->sentence(),
        ];
    }
}
