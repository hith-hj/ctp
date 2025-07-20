<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $collection = collect(['text', 'number', 'checkbox', 'color', 'select']);

        $shuffled = $collection->shuffle();

        $type = $shuffled->first();

        return [
            'name:en' => $this->faker->name,
            'type' => $type,
            'use_as_filter' => 1,
        ];
    }
}
