<?php

namespace Database\Factories;


use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Contact::class;
    public function definition()
    {
        return [
            'category_id' => 1,
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'gender' => $this->faker->numberBetween(1, 3),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->phoneNumber(),
            'address' => $this->faker->address,
            'building' => $this->faker->secondaryAddress,
            'detail' => $this->faker->text(100),
            'created_at' => now(),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}
