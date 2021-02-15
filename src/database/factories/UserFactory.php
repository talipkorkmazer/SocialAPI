<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => bin2hex(random_bytes(80)),
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' =>  Hash::make('password'), // password
            'full_name' => null,
            'bio' => null,
            'profile_picture' => null
        ];
    }
}
