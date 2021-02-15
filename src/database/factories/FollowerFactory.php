<?php

namespace Database\Factories;

use App\Models\Follower;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Follower::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $numberOne = $this->faker->numberBetween(1, 100);
        $numberTwo = $this->faker->numberBetween(1, 100);

        if ($numberOne == $numberTwo) {
            $numberTwo = $this->faker->numberBetween(1, 100);
        }

        return [
            'user_id' => $numberOne,
            'followed_user_id' => $numberTwo,
        ];
    }
}
