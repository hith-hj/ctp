<?php

namespace Database\Factories;

use App\Helpers\FakerHelper;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slider::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();
        $product_id = $product != null ? $product->id : null;

        return [
            'title' => 'Lighting',
            'brief' => fake()->word(),
            'sort_order' => fake()->unique()->randomElement([1, 2, 3, 4, 5]),
            'product_id' => $product_id,
            'background_image' => FakerHelper::getImageUrl(1920, 725),
            'responsive_image' => FakerHelper::getImageUrl(767, 700),
        ];
    }
}
