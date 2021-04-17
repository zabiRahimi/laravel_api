<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
    $faker = \Faker\Factory::create('fa_IR'); 

        return [
            'user_id' => 1,
            'title' => $this->faker->title,
            'body' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(5000, 60000),
            'image' => 'dfg12sfgzzz',
        ];
    }
}
