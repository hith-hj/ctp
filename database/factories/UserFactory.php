<?php

namespace Database\Factories;

use App\Helpers\FakerHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
     */
    public function definition(): array
    {
        $height = rand(600, 900);
        $width = intval($height * 2 / 3);

        return [
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'status' => 1,
            'city_id' => rand(1, 5),
            'phone_number' => $this->faker->phoneNumber,
            'avatar' => FakerHelper::getImageUrl($width, $height, 'NOT USED', false),
            'app_notification_status' => 'yes',
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ];
    }
}
