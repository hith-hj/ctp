<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }

    public function sar()
    {
        return $this->state([
            'name:en' => 'saudi Rial',
            'is_active' => 1,
            'code' => 'SAR',
            'symbol' => 'SAR',
            'rate' => 1,
        ]);
    }

    public function usd()
    {
        return $this->state([
            'name:en' => 'United States Dollar',
            'is_active' => 1,
            'code' => 'USD',
            'symbol' => '$',
            'rate' => 2.60,
        ]);
    }
}
