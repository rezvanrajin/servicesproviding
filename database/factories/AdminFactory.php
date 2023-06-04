<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "Admin",
            'user_type' => "Admin",
            'email' => "admin@gmail.com",
            'password' => bcrypt(123456), // password
        ];
    }
}
