<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $height = rand(600, 900);
        $width = intval($height * 2 / 3);

        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'username' => fake()->userName,
            'status' => 1,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'about' => fake()->text,
            'whatsapp' => fake()->phoneNumber,
            'phone_number' => fake()->phoneNumber,
            'website_url' => fake()->url,
            'facebook' => fake()->url,
            'instagram' => fake()->url,
            'avatar' => fake()->imageUrl($width / 2, $height / 2, 'NOT USED', false),
            'cover_image' => fake()->imageUrl($width, $height, 'NOT USED', false),
        ];
    }

    public function admin()
    {
        return $this->state([
            'name' => 'admin',
            'email' => 'admin@ctp.com',
            'username' => 'ctp.admin',
        ]);
    }

    public function vendor()
    {
        return $this->state([
            'name' => 'vendor',
            'email' => 'vendor@ctp.com',
            'username' => 'ctp.vendor',
        ]);
    }

    public function client()
    {
        return $this->state([
            'name' => 'client',
            'email' => 'client@ctp.com',
            'username' => 'ctp.client',
        ]);
    }

    public function shipping()
    {
        return $this->state([
            'name' => 'shipping',
            'email' => 'shipping@ctp.com',
            'username' => 'ctp.shipping',
        ]);
    }
}
