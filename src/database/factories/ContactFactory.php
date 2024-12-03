<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\Category;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->numberBetween(1,3),
            'email' => $this->faker->safeEmail,
            'tel1' => $this->faker->numberBetween(10000,99999),
            'tel2' => $this->faker->numberBetween(10000,99999),
            'tel3' => $this->faker->numberBetween(10000,99999),
            'address' => $this->faker->city,
            'building' => $this->faker->word,
            'category_id' => Category::inRandomOrder()->first()->id,
            'detail' => $this->faker->text(100)

        ];
    }
}
