<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use Faker\Generator as Faker; 


class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create(); // Create a new instance

        return [
            'title' => $faker->sentence(3, true),
            'description' => $faker->sentence(6, true),
            'price' => $faker->numberBetween(25, 150),
            'author_id' => $faker->numberBetween(1, 30),
        ];
    }

}
