<?php

namespace Database\Factories;

use App\Helpers\FakerHelper;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $height = rand(600, 900);
        $width = intval($height * 2 / 3);
        $parent = Category::query()->first();
        $parent_id = $parent != null ? $parent->id : 1;

        return [
            'name:en' => fake()->name,
            'sort_order' => fake()->numberBetween(1, 100),
            'is_active' => fake()->boolean(),
            'parent_category' => $parent_id,
            'image' => FakerHelper::getImageUrl($width, $height, 'NOT USED', false),
        ];
    }
}
